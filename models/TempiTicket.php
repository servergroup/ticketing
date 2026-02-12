<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class TempiTicket extends ActiveRecord
{
    public static function tableName()
    {
        return 'tempi_ticket';
    }

    public function rules()
    {
        return [
            [['id_ticket', 'id_operatore', 'tempo_lavorazione', 'pause_effettuate'], 'integer'],
            [['ora_inizio', 'ora_fine', 'chiuso_il'], 'safe'],
            [['tempi_pause', 'ora_pause'], 'safe'],
            [['stato'], 'string', 'max' => 50],
            [['tempo_sospensione'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_ticket' => 'Ticket',
            'id_operatore' => 'Operatore',
            'ora_inizio' => 'Ora Inizio',
            'ora_fine' => 'Ora Fine',
            'tempo_lavorazione' => 'Tempo Lavorazione (sec)',
            'pause_effettuate' => 'Pause Effettuate',
            'tempi_pause' => 'Tempi Pause (JSON)',
            'ora_pause' => 'Orari Pause (JSON)',
            'chiuso_il' => 'Chiuso il',
            'stato' => 'Stato',
            'tempo_sospensione' => 'Tempo Sospensione (HH:MM:SS)',
        ];
    }

    public function getTempiPauseArray(): array
    {
        if (empty($this->tempi_pause)) {
            return [];
        }
        return is_array($this->tempi_pause) ? $this->tempi_pause : (json_decode($this->tempi_pause, true) ?: []);
    }

    public function getOraPauseArray(): array
    {
        if (empty($this->ora_pause)) {
            return [];
        }
        return is_array($this->ora_pause) ? $this->ora_pause : (json_decode($this->ora_pause, true) ?: []);
    }

    public function setTempiPauseArray(array $arr): void
    {
        $this->tempi_pause = $arr;
    }

    public function setOraPauseArray(array $arr): void
    {
        $this->ora_pause = $arr;
    }

    public function getTempoSospeso(): string
    {
        if (empty($this->tempo_sospensione)) {
            return "00:00:00";
        }

        $parts = explode(':', $this->tempo_sospensione);
        while (count($parts) < 3) {
            $parts[] = '00';
        }

        list($h, $m, $s) = $parts;
        $h = (int)$h; $m = (int)$m; $s = (int)$s;

        return sprintf('%02d:%02d:%02d', $h, $m, $s);
    }

    public function getTempoEffettivo(): string
    {
        if (empty($this->ora_inizio) || empty($this->ora_fine)) {
            return "00:00:00";
        }

        $inizio = strtotime($this->ora_inizio);
        $fine = strtotime($this->ora_fine);
        if ($inizio === false || $fine === false || $fine < $inizio) {
            return "00:00:00";
        }

        $totale = $fine - $inizio;

        $pauseArr = $this->getTempiPauseArray();
        $pause = 0;
        foreach ($pauseArr as $p) {
            if (is_numeric($p)) $pause += (int)$p;
        }

        $sosp = 0;
        if (!empty($this->tempo_sospensione)) {
            $parts = explode(':', $this->tempo_sospensione);
            while (count($parts) < 3) $parts[] = '00';
            $sosp = ((int)$parts[0]) * 3600 + ((int)$parts[1]) * 60 + ((int)$parts[2]);
        }

        $effettivo = $totale - $pause - $sosp;
        if ($effettivo < 0) $effettivo = 0;

        $ore = floor($effettivo / 3600);
        $min = floor(($effettivo % 3600) / 60);
        $sec = $effettivo % 60;

        return sprintf('%02d:%02d:%02d', $ore, $min, $sec);
    }

    public function startPause(): bool
    {
        $oraPause = $this->getOraPauseArray();
        $oraPause[] = time();
        $this->setOraPauseArray($oraPause);
        return $this->save(false);
    }

    public function stopPause(): bool
    {
        $oraPause = $this->getOraPauseArray();
        if (empty($oraPause)) {
            return false;
        }

        $start = array_pop($oraPause);
        if (!is_numeric($start)) {
            $this->setOraPauseArray($oraPause);
            $this->save(false);
            return false;
        }

        $durata = time() - (int)$start;
        if ($durata < 0) $durata = 0;

        $tempi = $this->getTempiPauseArray();
        $tempi[] = $durata;

        $this->setOraPauseArray($oraPause);
        $this->setTempiPauseArray($tempi);

        $this->pause_effettuate = (int)$this->pause_effettuate + 1;

        return $this->save(false);
    }

    public function startSospensione(): bool
    {
        $this->stato = 'sospeso';
        $this->chiuso_il = date('Y-m-d H:i:s');
        return $this->save(false);
    }

    public function stopSospensione(): bool
    {
        if (empty($this->chiuso_il)) {
            return false;
        }

        $inizio = strtotime($this->chiuso_il);
        if ($inizio === false) {
            return false;
        }

        $durata = time() - $inizio;
        if ($durata < 0) $durata = 0;

        $existing = 0;
        if (!empty($this->tempo_sospensione)) {
            $parts = explode(':', $this->tempo_sospensione);
            while (count($parts) < 3) $parts[] = '00';
            $existing = ((int)$parts[0]) * 3600 + ((int)$parts[1]) * 60 + ((int)$parts[2]);
        }

        $totale = $existing + $durata;

        $h = floor($totale / 3600);
        $m = floor(($totale % 3600) / 60);
        $s = $totale % 60;

        $this->tempo_sospensione = sprintf('%02d:%02d:%02d', $h, $m, $s);

        $this->chiuso_il = null;
        $this->stato = 'in_lavorazione';

        return $this->save(false);
    }

    public static function creaRecordTempi(int $idTicket, ?int $idOperatore = null): ?self
    {
        $tempi = new self();
        $tempi->id_ticket = $idTicket;
        $tempi->id_operatore = $idOperatore;
        $tempi->ora_inizio = date('H:i:s');
        $tempi->ora_fine = null;
        $tempi->tempo_lavorazione = 0;
        $tempi->pause_effettuate = 0;
        $tempi->tempi_pause = [];
        $tempi->ora_pause = [];
        $tempi->chiuso_il = null;
        $tempi->stato = 'nuovo';
        $tempi->tempo_sospensione = "00:00:00";

        return $tempi->save(false) ? $tempi : null;
    }

    public function beforeSave($insert)
    {
        // normalizza tempi_pause
        if (!is_array($this->tempi_pause)) {
            if (empty($this->tempi_pause)) {
                $this->tempi_pause = [];
            } else {
                $decoded = json_decode($this->tempi_pause, true);
                $this->tempi_pause = $decoded !== null ? $decoded : [];
            }
        }

        // normalizza ora_pause
        if (!is_array($this->ora_pause)) {
            if (empty($this->ora_pause)) {
                $this->ora_pause = [];
            } else {
                $decoded = json_decode($this->ora_pause, true);
                $this->ora_pause = $decoded !== null ? $decoded : [];
            }
        }

        // calcolo tempo_lavorazione se possibile
        if (!empty($this->ora_inizio) && !empty($this->ora_fine)) {
            $inizio = strtotime($this->ora_inizio);
            $fine = strtotime($this->ora_fine);

            if ($inizio !== false && $fine !== false && $fine >= $inizio) {
                $totale = $fine - $inizio;

                $pauseArr = $this->getTempiPauseArray();
                $pause = 0;
                foreach ($pauseArr as $p) {
                    if (is_numeric($p)) $pause += (int)$p;
                }

                $sosp = 0;
                if (!empty($this->tempo_sospensione)) {
                    $parts = explode(':', $this->tempo_sospensione);
                    while (count($parts) < 3) $parts[] = '00';
                    $sosp = ((int)$parts[0]) * 3600 + ((int)$parts[1]) * 60 + ((int)$parts[2]);
                }

                $effettivo = $totale - $pause - $sosp;
                if ($effettivo < 0) $effettivo = 0;

                $this->tempo_lavorazione = (int)$effettivo;
            }
        }

        return parent::beforeSave($insert);
    }
}

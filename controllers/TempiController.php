<?php

namespace app\controllers;

use Yii;
use app\models\TempiTicket;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TempiController extends Controller
{
    public function actionIndex()
    {
        $model = TempiTicket::find()->all();
        return $this->render('index', ['model' => $model]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new TempiTicket();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /* -------------------------
       🔵 GESTIONE PAUSE
       ------------------------- */

    public function actionStartPause($id)
    {
        $model = $this->findModel($id);

        $pause = $model->tempi_pause ?? [];
        $pause[] = time(); // salva timestamp inizio pausa

        $model->tempi_pause = $pause;
        $model->stato = 'in_pausa';
        $model->save(false);

        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionStopPause($id)
    {
        $model = $this->findModel($id);

        $pause = $model->tempi_pause ?? [];

        $inizio = array_pop($pause);
        $durata = time() - $inizio;

        $pause[] = $durata;
        $model->tempi_pause = $pause;
        $model->stato = 'in_lavorazione';
        $model->save(false);

        return $this->redirect(['update', 'id' => $id]);
    }

    /* -------------------------
       🔵 GESTIONE SOSPENSIONI
       ------------------------- */

    public function actionStartSospensione($id)
    {
        $model = $this->findModel($id);

        $model->stato = 'sospeso';
        $model->chiuso_il = date('Y-m-d H:i:s'); // salva inizio sospensione
        $model->save(false);

        return $this->redirect(['update', 'id' => $id]);
    }

    public function actionStopSospensione($id)
    {
        $model = $this->findModel($id);

        $inizio = strtotime($model->chiuso_il);
        $fine = time();
        $durata = $fine - $inizio;

        $h = floor($durata / 3600);
        $m = floor(($durata % 3600) / 60);
        $s = $durata % 60;

        $model->tempo_sospensione = sprintf('%02d:%02d:%02d', $h, $m, $s);
        $model->stato = 'in_lavorazione';
        $model->save(false);

        return $this->redirect(['update', 'id' => $id]);
    }

    /* -------------------------
       🔵 FIND MODEL
       ------------------------- */

    protected function findModel($id)
    {
        if (($model = TempiTicket::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Record non trovato.');
    }
}

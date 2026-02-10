<?php

use yii\helpers\Html;
use app\models\Ticket;
use app\models\Turni;

/** @var app\models\User[] $dipendenti */

?>
<style>
.turni-container {
    max-width: 1100px;
    margin: 30px auto;
    font-family: "Inter", "Segoe UI", Arial, sans-serif;
}

.table-card {
    background: #ffffff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
}

.table-title {
    font-size: 22px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 18px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.table-title i {
    color: #0056b3;
    font-size: 22px;
}

.ticket-table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
    border-radius: 10px;
    overflow: hidden;
}

.ticket-table thead {
    background: #f3f6fa;
    border-bottom: 2px solid #e1e7ef;
}

.ticket-table th {
    padding: 14px;
    font-size: 14px;
    color: #34495e;
    font-weight: 600;
}

.ticket-table td {
    padding: 14px;
    font-size: 14px;
    color: #2c3e50;
    border-bottom: 1px solid #f1f4f8;
}

.ticket-table tbody tr:hover {
    background: #f9fbff;
}

.muted {
    color: #9aa4b1;
    font-style: italic;
}

.action-cell {
    text-align: center;
}

.action-btn {
    background: #0056b3;
    color: white;
    padding: 8px 10px;
    border-radius: 6px;
    font-size: 14px;
    transition: background 0.2s, transform 0.1s;
}

.action-btn:hover {
    background: #003f82;
    transform: scale(1.05);
}

.action-btn i {
    font-size: 16px;
}
</style>

<div class="turni-container">
    <div class="table-card">
        <h2 class="table-title">
            <i class="fas fa-users-cog"></i> Gestione Turni Operatori
        </h2>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Entrata</th>
                    <th>Uscita</th>
                    <th>Pausa</th>
                    <th style="text-align:center;">Azioni</th>
                </tr>
            </thead>

            <tbody>
            <?php foreach($dipendenti as $dipendenti_item):
                $turni = Turni::findOne(['id_operatore' => $dipendenti_item->id]);
            ?>
                <tr>
                    <td><?= Html::encode($dipendenti_item->id) ?></td>
                    <td><?= Html::encode($dipendenti_item->nome) ?></td>
                    <td><?= Html::encode($dipendenti_item->cognome) ?></td>

                    <td><?= $turni && $turni->entrata ? Html::encode($turni->entrata) : '<span class="muted">Non definita</span>' ?></td>
                    <td><?= $turni && $turni->uscita ? Html::encode($turni->uscita) : '<span class="muted">Non definita</span>' ?></td>
                    <td><?= $turni && $turni->pausa ? Html::encode($turni->pausa) : '<span class="muted">Non definita</span>' ?></td>

                    <td class="action-cell">
                        <?= Html::a(
                            '<i class="fas fa-edit"></i>',
                            ['modify-turni', 'id_operatore' => $dipendenti_item->id],
                            ['class' => 'action-btn']
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

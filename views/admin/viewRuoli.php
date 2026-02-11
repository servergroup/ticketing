<?php

use yii\helpers\Html;
use app\models\Ticket;
use app\models\Turni;

/** @var app\models\User[] $user */

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
            <i class="fas fa-users-cog" style="margin-left:380px;"></i>Gestione Turni Operatori
        </h2>

        <table class="ticket-table">
            <thead>
                <tr>
                    <th style="text-align:center">Id</th>
                    <th style="text-align:center">Nome</th>
                    <th style="text-align:center">Cognome</th>
                    <th style="text-align:center">Ruolo</th>
                 
                    
                </tr>
            </thead>

            <tbody>
            <?php foreach($user as $user):
              
            ?>
                <tr>
                    <td style="text-align:center"><?= Html::encode($user->id) ?></td>
                    <td style="text-align:center"><?= Html::encode($user->nome) ?></td>
                    <td style="text-align:center"><?= Html::encode($user->cognome) ?></td>
                    <td style="text-align:center"><?= Html::encode($user->ruolo) ?></td>

           

                   
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 

use yii\helpers\Html;
use app\models\User;

/** @var app\models\Reclamo[] $reclamo */

?>

<div class="reclamo-container">

    <h2 class="title">Elenco Reclami</h2>

    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Azienda</th>
                <th>Reclamo</th>
                <th>Visualizzato</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($reclamo as $reclamo_item): ?>
                <?php $personale = User::findOne($reclamo_item->id_cliente); ?>

                <tr>
                    <td><?= Html::encode($reclamo_item->id) ?></td>
                    <td><?= Html::encode($personale->nome ?? 'N/D') ?></td>
                    <td><?= Html::encode($personale->cognome ?? 'N/D') ?></td>
                    <td><?= Html::encode($reclamo_item->azienda) ?></td>
                    <td><?= Html::encode($reclamo_item->problema) ?></td>
                    <td>
                        <span class="badge <?= $reclamo_item->visualizzato ? 'badge-success' : 'badge-danger' ?>">
                            <?= $reclamo_item->visualizzato ? 'Sì' : 'No' ?>
                        </span>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<style>
.reclamo-container {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.table th {
    background: #f4f4f4;
    font-weight: 600;
    text-align: center;
}

.table td {
    vertical-align: middle;
}

.badge-success {
    background-color: #28a745;
    padding: 6px 12px;
    border-radius: 4px;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    padding: 6px 12px;
    border-radius: 4px;
    color: white;
}
</style>

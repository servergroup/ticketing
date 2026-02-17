<?php
use yii\helpers\Html;
use app\models\Ticket;
use app\models\Turni;
use app\models\User;
use yii\base\View;
use app\assets\AppAsset;

AppAsset::register($this);
/** @var app\models\Turni[] $dipendenti*/
?>

<div class="turni-wrapper">

    <h1 class="turni-title">
        <i class="fas fa-users-cog"></i>
        Tabellone dei turni degli operatori
    </h1>

    <?php if (empty($dipendenti)): ?>
        <p class="no-results">Nessun risultato trovato.</p>

    <?php else: ?>

        <table class="table table-hover table-striped align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Entrata</th>
                    <th>Uscita</th>
                    <th>Pausa</th>
                    
                </tr>
            </thead>

            <tbody>
                <?php foreach ($dipendenti as $dipendenti_item): ?>
                    <?php $turni = Turni::findOne(['id_operatore' => $dipendenti_item->id]); ?>

                    <tr>
                        <td><p><strong>ID:</strong> <?= Html::encode($turni->id) ?></p></td>
                        <td><p><strong>Nome:</strong> <?= Html::encode($dipendenti_item->nome) ?></p></td>
                        <td><p><strong>Cognome:</strong> <?= Html::encode($dipendenti_item->cognome) ?></p></td>
                        <td><p><strong>Entrata:</strong> <?= Html::encode($turni->entrata) ?></p></td>
                        <td><p><strong>Uscita:</strong> <?= Html::encode($turni->uscita) ?></p></td>
                       

                        <td>
                            <p><strong>Pausa:</strong>
                                <?= $turni->pausa ? Html::encode($turni->pausa) : "Non definita" ?>
                            </p>
                        </td>

                         <td><p><strong>   <td class="action-cell">
                        <?= Html::a(
                            '<i class="fas fa-edit"></i>',
                            ['modify-turni', 'id_operatore' => $dipendenti_item->id],
                            ['class' => 'action-btn']
                        ) ?>
                    </td></strong></p></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

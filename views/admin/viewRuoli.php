<?php

use yii\helpers\Html;
use app\models\Ticket;
use app\models\Turni;

/** @var app\models\User[] $user */

?>
<div class="turni-wrapper">

    <h1 class="turni-title" style="text-align:center">
        <i class="fas fa-users-cog"></i>
        Tabellone dei ruoli operativi
    </h1>

    <?php if (empty($user)): ?>
        <p class="no-results">Nessun risultato trovato.</p>

    <?php else: ?>

        <table class="table table-hover table-striped align-middle shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Ruolo</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($user as $user): ?>
                   

                    <tr>
                        <td><p><strong>ID:</strong> <?= Html::encode($user->id) ?></p></td>
                        <td><p><strong>Nome:</strong> <?= Html::encode($user->nome) ?></p></td>
                        <td><p><strong>Cognome:</strong> <?= Html::encode($user->cognome) ?></p></td>
                        <td><p><strong>Ruolo:</strong> <?= Html::encode($user->ruolo) ?></p></td>
                        <td><p><strong><?= Html::a(
                            '<i class="fas fa-edit"></i>',
                            ['update-ruolo', 'id' => $user->id],
                            ['class' => 'action-btn']
                        ) ?></strong></p></td>
                        

                       
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>

<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Ticket in attesa';
?>

<h1 style="text-align:center;"><?= Html::encode($this->title) ?></h1>

<table class="table table-striped table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Ruolo</th>
            <th>Username</th>
            <th>Tentativi</th>
            <th>Approvazione</th>
            <th>Assegna ruolo</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($users as $user_item): ?>
        <tr>

            <!-- COLONNA RUOLO -->
            <td>
                <?php if ($user_item->ruolo === 'personale'){?>

                    <?php $form = ActiveForm::begin([
                        'action' => ['admin/modify-ruolo', 'id' => $user_item->id],
                        'method' => 'post'
                    ]); ?>

                    <?= $form->field($user_item, 'ruolo')->dropDownList(
                        [
                            'developer' => 'developer',
                            'ict' => 'ict',
                            'amministratore' => 'amministratore'
                        ],
                        [
                            'prompt' => "Definisci un ruolo",
                            'class' => 'form-select'
                        ]
                    )->label(false) ?>

                <?php
                }else{
                ?>
                <?= Html::encode($user_item->ruolo)?>
                <?php } ?>
            </td>

            <!-- USERNAME -->
            <td><?= Html::encode($user_item->username) ?></td>

            <!-- TENTATIVI -->
            <td><?= Html::encode($user_item->tentativi) ?></td>

            <!-- APPROVAZIONE -->
            <td>
                <?php if (!$user_item->approvazione): ?>
                    Non approvato
                <?php else: ?>
                    Approvato
                <?php endif; ?>
            </td>

            <!-- BOTTONI -->
            <td>
                <?php if (!$user_item->approvazione): ?>
                    <?= Html::a('Approva', ['admin/approva', 'username' => $user_item->username], ['class' => 'btn btn-primary']) ?>
                <?php endif; ?>

                <?php if ($user_item->ruolo === 'personale'){?>
                    <?= Html::submitButton('Assegna ruolo', ['class' => 'btn btn-sm btn-primary']) ?>
                    <?php ActiveForm::end(); ?>
                <?php }else{
                    ?>
                     <?= Html::a('modifica il ruolo',['admin/update-ruolo','id'=>$user_item->id],['class'=>'btn btn-primary']);?>
                <?php
                    }
                ?>
            </td>

        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

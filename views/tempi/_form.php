<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TempiTicket $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tempi-ticket-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_ticket')->textInput() ?>

    <?= $form->field($model, 'id_operatore')->textInput() ?>

    <?= $form->field($model, 'ora_inizio')->textInput() ?>

    <?= $form->field($model, 'ora_fine')->textInput() ?>

    <?= $form->field($model, 'tempo_lavorazione')->textInput() ?>

    <?= $form->field($model, 'pause_effettuate')->textInput() ?>

    <?= $form->field($model, 'tempi_pause')->textInput() ?>

    <?= $form->field($model, 'ora_pause')->textInput() ?>

    <?= $form->field($model, 'chiuso_il')->textInput() ?>

    <?= $form->field($model, 'stato')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tempo_sospensione')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

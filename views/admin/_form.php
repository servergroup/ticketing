<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Turni $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="turni-form">

    <?php $form = ActiveForm::begin(); ?>

   

    <?= $form->field($model, 'entrata')->textInput() ?>

    <?= $form->field($model, 'uscita')->textInput() ?>

    <?= $form->field($model, 'pausa')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\reclami $model */
/** @var ActiveForm $form */
?>
<div class="client-reclamo">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'problema') ?>
        <?= $form->field($model, 'azienda') ?>
        <?= $form->field($model, 'id_cliente') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- client-reclamo -->

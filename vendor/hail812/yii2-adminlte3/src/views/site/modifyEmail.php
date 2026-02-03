<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (Yii::$app->session->hasFlash('success')) {
    $msg = Yii::$app->session->getFlash('success');
    $this->registerJs("
        Swal.fire({
            title: '$msg',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    ");
}

if (Yii::$app->session->hasFlash('error')) {
    $msg = Yii::$app->session->getFlash('error');
    $this->registerJs("
        Swal.fire({
            title: '$msg',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    ");
}
?>

<style>
    .form-wrapper {
        max-width: 480px;
        margin: 60px auto;
        background: #ffffff;
        padding: 35px 40px;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        border: 1px solid #e5e5e5;
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper h2 {
        font-weight: 600;
        font-size: 22px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .ds-input {
        border-radius: 8px !important;
        height: 42px;
        border: 1px solid #ccc;
        padding-left: 12px;
    }

    .btn-primary {
        width: 100%;
        height: 45px;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        background-color: #0057b8;
        border-color: #0057b8;
    }

    .btn-primary:hover {
        background-color: #004a9c;
        border-color: #004a9c;
    }

    label {
        font-weight: 500;
        color: #444;
    }
</style>

<div class="form-wrapper">

    <h2>Modifica Email Utente</h2>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'email')->hiddenInput([
            'placeholder' => 'Email attuale',
            'value' =>Yii::$app->user->identity->username,
            
            'readonly' => true,
            'class' => 'ds-input'
        ])->label('Email attuale') ?>

        <?= $form->field($user, 'email')->passwordInput([
            'placeholder' => 'Nuova email',
            'class' => 'ds-input'
        ])->label('Nuova email') ?>

        <div class="form-group mt-3">
            <?= Html::submitButton('Conferma Modifica', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

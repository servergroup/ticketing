<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\LogAsset;
use yii\web\View;

/** @var yii\web\View $this */
/** @var app\models\reclami $reclamo */

$this->title = '';
LogAsset::register($this);


?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// FLASH SUCCESS
if (Yii::$app->session->hasFlash('success')) {
    $msg = Yii::$app->session->getFlash('success');
    $this->registerJs("
        Swal.fire({
            icon: 'success',
            title: " . json_encode($msg) . ",
            confirmButtonText: 'OK'
        });
    ", View::POS_END);
}

// FLASH ERROR
if (Yii::$app->session->hasFlash('error')) {
    $msg = Yii::$app->session->getFlash('error');
    $this->registerJs("
        Swal.fire({
            icon: 'error',
            title: " . json_encode($msg) . ",
            confirmButtonText: 'OK'
        });
    ", View::POS_END);
}
?>


<div class="reclamo">

    <h1>Reclama</h1>
    <p>Compilare il seguente modulo per inviare un reclamo</p>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($reclamo, 'problema')->textarea(['placeholder' => 'Descrivi il problema']) ?>
 



    <div class="form-group">
        <?= Html::submitButton('Invia Ticket', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div><!-- ticket-newTicket -->

<style>
    body {
        background: #f4f6f9;
        font-family: "Segoe UI", Roboto, Arial, sans-serif;
    }

    /* ====== Contenitore principale ====== */
    .reclamo {
        width: 480px;
        margin: 60px auto;
        background: #ffffff;
        border: 1px solid #e1e1e1;
        border-radius: 12px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        padding: 30px;
    }

    /* ====== Titolo ====== */
    .reclamo h1 {
        font-size: 20px;
        font-weight: 600;
        color: #2c3e50;
        text-align: center;
        margin-bottom: 25px;
    }

    /* ====== Input, select e textarea ====== */
    .reclamo .form-control {
        border-radius: 6px;
        border: 1px solid #cfcfcf;
        padding: 10px;
        font-size: 15px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .reclamo .form-control:focus {
        border-color: #0066cc;
        box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.15);
    }

    /* ====== Label ====== */
    .reclamo .control-label {
        font-weight: 500;
        color: #2c3e50;
    }

    /* ====== Pulsante ====== */
    .reclamo .btn-primary {
        background-color: #0066cc;
        border-color: #005bb5;
        padding: 10px 18px;
        font-size: 15px;
        border-radius: 6px;
        width: 100%;
        transition: all 0.25s ease-in-out;
    }

    .reclamo .btn-primary:hover {
        background-color: #005bb5;
        border-color: #004f9e;
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0, 102, 204, 0.25);
    }

    /* ====== Spaziatura campi ====== */
    .reclamo.form-group {
        margin-bottom: 18px;
    }

    </style
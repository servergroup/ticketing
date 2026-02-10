<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket $ticket */
/** @var ActiveForm $form */
?>
<div class="modifyTicket">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($ticket, 'problema') ?>
    <?= $form->field($ticket, 'ambito')->dropDownList(
        [
            'ict' => 'Sistemistica',
            'sviluppo' => 'Sviluppo'
        ]
    ) ?>

    


    <?= $form->field($ticket, 'priorita')->dropDownList(
        [
            'alta' => 'Alta',
            'media' => 'Media',
            'bassa' => 'Bassa'
        ]
    ) ?>

    <?php 
    
    if(Yii::$app->user->identity->ruolo=='amministratore') :?>
    <?= $form->field($ticket,'scadenza')->input('date') ?>

    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton('Modifica', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div><!-- modifyTicket -->



<style>

    .modifyTicket {
    max-width: 600px;
    margin: 40px auto;
    padding: 30px;
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #e3e6ea;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
}

/* Titoli */
.modifyTicket h1,
.modifyTicket h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 25px;
}

/* Campi input */
.modifyTicket .form-control {
    border-radius: 6px;
    border: 1px solid #cfd4da;
    padding: 10px;
    font-size: 15px;
    transition: all .2s ease-in-out;
}

.modifyTicket .form-control:focus {
    border-color: #0066cc;
    box-shadow: 0 0 0 3px rgba(0,102,204,0.15);
}

/* Label */
.modifyTicket label {
    font-weight: 600;
    color: #34495e;
}

/* Dropdown */
.modifyTicket select.form-control {
    cursor: pointer;
}

/* Pulsante */
.modifyTicket .btn-primary {
    background-color: #0066cc;
    border-color: #005bb5;
    padding: 10px 18px;
    font-size: 15px;
    border-radius: 6px;
    width: 100%;
    transition: all .25s ease-in-out;
}

.modifyTicket .btn-primary:hover {
    background-color: #005bb5;
    border-color: #004f9e;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 102, 204, 0.25);
}

/* Spaziature */
.modifyTicket .form-group {
    margin-top: 25px;
}

/* Responsive */
@media (max-width: 480px) {
    .modifyTicket {
        padding: 20px;
        margin: 20px;
    }
}

</style>
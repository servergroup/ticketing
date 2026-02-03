<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\assets\TicketAsset;
use app\models\ticketFunction;
use yii\web\View;
/** @var yii\web\View $this */
/** @var app\models\Ticket $ticket */

$this->title = '';
TicketAsset::register($this);


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
/** @var yii\web\View $this */
/** @var app\models\Ticket $ticket */
?>
<div class="ticket-newTicket">

    <h1>Nuovo Ticket</h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($ticket, 'problema')->textInput(['placeholder' => 'Descrivi il problema']) ?>

        <?= $form->field($ticket, 'ambito')->dropDownList([
            'itc' => 'ITC',
            'sviluppo' => 'Sviluppo'
        ], ['prompt' => 'Seleziona ambito']) ?>

        <?= $form->field($ticket, 'scadenza')->input('date') ?>

        <?= $form->field($ticket, 'azienda')->textInput(['placeholder' => 'Nome azienda']) ?>

        <?= $form->field($ticket, 'id_cliente')->hiddenInput()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Invia Ticket', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div><!-- ticket-newTicket -->

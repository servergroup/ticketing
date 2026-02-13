<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket[] $ticket */
/** @var app\models\Ticket $searchTicket */
?>


<h1 class="text-center mb-2">I miei ticket</h1>

<div class="text-center mb-4">
    <?php $form = ActiveForm::begin([
        'id' => 'ticketSearchForm',
        'method' => 'post',
        'action' => Yii::$app->request->url,
        'options' => ['class' => 'd-flex justify-content-center gap-2']
    ]); ?>
        <?= $form->field($searchTicket, 'codice_ticket')
            ->textInput([
                'placeholder' => 'Cerca codice ticket...',
                'id' => 'liveSearchTicket',
                'class' => 'form-control form-control-lg'
            ])
            ->label(false) ?>
    <?php ActiveForm::end(); ?>
</div>

<div id="ticketTableContainer">
    <?= $this->render('_ticketTable', ['ticket' => $ticket]) ?>
</div>


<script>
let timer;
$('#liveSearchTicket').on('keyup', function() {
    clearTimeout(timer);
    timer = setTimeout(() => {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: { 'Ticket[codice_ticket]': $('#liveSearchTicket').val() },
            cache: false,
            success: function(data) {
                $('#ticketTableContainer').html(data);
            }
        });
    }, 200);
});
</script>

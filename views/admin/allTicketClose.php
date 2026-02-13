<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket[] $ticket */
/** @var app\models\Ticket $searchTicket */
?>

<h1 class="text-center mb-2">Stato dei miei ticket</h1>


<!-- FORM DI RICERCA -->
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

<!-- CONTAINER PER LA TABELLA (AJAX LIVE SEARCH) -->
<div id="ticketTableContainer">
    <?= $this->render('_ticketTable', ['ticket' => $ticket]) ?>
</div>

<!-- MODAL: CONFERMA ELIMINAZIONE -->
<div class="modal fade" id="deleteTicketModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Conferma eliminazione</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler eliminare questo ticket?  
        L’operazione non può essere annullata.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Elimina</a>
      </div>
    </div>
  </div>
</div>

<!-- MODAL: COPIA CODICE TICKET -->
<div class="modal fade" id="copyTicketModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Codice Ticket</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="mb-2">Copia il codice del ticket:</p>
        <input id="ticketCodeToCopy" class="form-control text-center fw-bold" readonly>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
        <button id="copyCodeBtn" class="btn btn-primary">Copia</button>
      </div>
    </div>
  </div>
</div>

<?php
$script = <<<JS

/* 🔍 Ricerca live */
$('#liveSearchTicket').on('keyup', function() {
    var searchVal = $(this).val();
    $.ajax({
        type: 'POST',
        url: window.location.href,
        data: { 'Ticket[codice_ticket]': searchVal },
        success: function(data) {
            $('#ticketTableContainer').html(data);
        }
    });
});

/* 🗑️ Apertura modal eliminazione */
$(document).on('click', '.btn-delete-ticket', function() {
    let deleteUrl = $(this).data('url');
    $('#confirmDeleteBtn').attr('href', deleteUrl);
    var modal = new bootstrap.Modal(document.getElementById('deleteTicketModal'));
    modal.show();
});

/* 📋 Apertura modal copia codice */
$(document).on('click', '.btn-copy-ticket', function() {
    let code = $(this).data('code');
    $('#ticketCodeToCopy').val(code);
    var modal = new bootstrap.Modal(document.getElementById('copyTicketModal'));
    modal.show();
});

/* 📋 Copia negli appunti */
$('#copyCodeBtn').on('click', function() {
    let input = document.getElementById('ticketCodeToCopy');
    input.select();
    navigator.clipboard.writeText(input.value);
});
JS;

$this->registerJs($script);
?>

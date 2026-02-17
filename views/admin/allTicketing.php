<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket[] $ticket */
?>

<h1 class="text-center mb-4">Stato dei miei ticket</h1>

<!-- 🔍 FILTRI -->
<div class="d-flex justify-content-center gap-2 mb-4">

    <select id="filterType" class="form-select form-select-lg" style="max-width:220px;">
        <option value="codice_ticket">Codice Ticket</option>
        <option value="azienda">Azienda</option>
        <option value="stato">Stato</option>
        <option value="problema">Problema</option>
        <option value="id_cliente">ID Cliente</option>
    </select>

    <input id="filterValue" 
           class="form-control form-control-lg"
           placeholder="Cerca...">
</div>

<!-- 🔄 CONTENITORE TABELLA -->
<div id="ticketTableContainer">
    <?= $this->render('_ticketTable', ['ticket' => $ticket]) ?>
</div>

<!-- MODAL ELIMINAZIONE -->
<div class="modal fade" id="deleteTicketModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Conferma eliminazione</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler eliminare questo ticket?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <a id="confirmDeleteBtn" class="btn btn-danger">Elimina</a>
      </div>
    </div>
  </div>
</div>

<!-- MODAL COPIA CODICE -->
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

/* 🔍 FILTRO LIVE */
let timer;

$(document).on('keyup change', '#filterValue, #filterType', function() {

    clearTimeout(timer);

    timer = setTimeout(() => {

        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: {
                filterType: $('#filterType').val(),
                filterValue: $('#filterValue').val()
            },
            success: function(response) {
                $('#ticketTableContainer').html(response);
            },
            error: function(xhr) {
                console.error("ERRORE AJAX:", xhr.responseText);
            }
        });

    }, 200);
});

/* 🗑️ MODAL ELIMINAZIONE */
$(document).on('click', '.btn-delete-ticket', function() {
    $('#confirmDeleteBtn').attr('href', $(this).data('url'));
    new bootstrap.Modal(document.getElementById('deleteTicketModal')).show();
});

/* 📋 MODAL COPIA CODICE */
$(document).on('click', '.btn-copy-ticket', function() {
    $('#ticketCodeToCopy').val($(this).data('code'));
    new bootstrap.Modal(document.getElementById('copyTicketModal')).show();
});

/* 📋 COPIA */
$('#copyCodeBtn').on('click', function() {
    navigator.clipboard.writeText($('#ticketCodeToCopy').val());
});

JS;

$this->registerJs($script);
?>

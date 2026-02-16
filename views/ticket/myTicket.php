<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Ticket[] $ticket */
/** @var app\models\Ticket $searchTicket */

$this->title = 'I miei ticket';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<h1 class="text-center mb-2"><?= Html::encode($this->title) ?></h1>

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

<!-- Modal conferma eliminazione -->
<div class="modal fade" id="deleteTicketModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Conferma eliminazione</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Sei sicuro di voler eliminare questo ticket? L'operazione non può essere annullata.
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
        <a id="confirmDeleteBtn" class="btn btn-danger" href="#">Elimina</a>
      </div>
    </div>
  </div>
</div>

<!-- Toast feedback -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
  <div id="copyToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body">Copiato negli appunti</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Chiudi"></button>
    </div>
  </div>
</div>

<?php
$script = <<<JS
// Debounce per la ricerca live
let searchTimer;
$(document).on('keyup', '#liveSearchTicket', function() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        $.ajax({
            type: 'POST',
            url: window.location.href,
            data: { 'Ticket[codice_ticket]': $('#liveSearchTicket').val() },
            cache: false,
            success: function(data) {
                $('#ticketTableContainer').html(data);
            },
            error: function() {
                console.error('Errore nella richiesta AJAX di ricerca');
            }
        });
    }, 220);
});

// Delegated: copia diretta del codice (senza modal)
$(document).on('click', '.btn-copy-ticket', function(e) {
    e.preventDefault();
    const code = $(this).data('code') || '';
    if (!code) return;

    // prova navigator.clipboard
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(code).then(() => {
            showToast('Copiato negli appunti');
        }).catch(() => {
            fallbackCopy(code);
        });
    } else {
        fallbackCopy(code);
    }
});

function fallbackCopy(text) {
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.left = '-9999px';
    document.body.appendChild(ta);
    ta.focus();
    ta.select();
    try {
        const ok = document.execCommand('copy');
        showToast(ok ? 'Copiato negli appunti' : 'Copia non riuscita');
    } catch (err) {
        console.error('Fallback copy failed', err);
        showToast('Copia non riuscita');
    }
    document.body.removeChild(ta);
}

function showToast(message) {
    const toastEl = document.getElementById('copyToast');
    if (!toastEl) return;
    toastEl.querySelector('.toast-body').textContent = message;
    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}

// Delegated: apertura modal eliminazione
$(document).on('click', '.btn-delete-ticket', function(e) {
    e.preventDefault();
    const deleteUrl = $(this).data('url');
    if (!deleteUrl) return;
    $('#confirmDeleteBtn').attr('href', deleteUrl);
    const modalEl = document.getElementById('deleteTicketModal');
    if (modalEl) new bootstrap.Modal(modalEl).show();
});

// Optional: conferma eliminazione via href (se vuoi usare GET)
// $(document).on('click', '#confirmDeleteBtn', function(e) {
//     // default: segue l'href; se preferisci POST, intercetta qui e invia AJAX
// });
JS;
$this->registerJs($script);
?>

<?php
$css = <<<CSS
/* Piccoli stili per migliorare l'aspetto */
.table-hover .btn { min-width: 40px; }
#ticketTableContainer { min-height: 40px; }
CSS;
$this->registerCss($css);
?>

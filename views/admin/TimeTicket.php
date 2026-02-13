<?php
use yii\helpers\Html;
use app\models\User;
use app\models\Ticket;
/** @var yii\web\View $this */
/** @var app\models\TempiTicket[] $tempi */
?>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<h1 class="text-center">Stato dei miei ticket</h1>
<p class="text-center">Qui vedrai lo stato dei tuoi ticket</p>

<?php if (empty($ticket)): ?>
    <p class="text-center mt-4">Non hai ancora ticket aperti.</p>
<?php else: ?>

<table class="table table-bordered table-striped mt-4">
    <thead class="table-dark">
        <tr>
            <th>Codice Ticket</th>
            <th>Inizio</th>
            <th>Fine</th>
            <th>Tempo lavorazione</th>
            <th>Operatore</th>
        </tr>
    </thead>

    <tbody>
       <?php foreach ($tempi as $tempi_item): ?>

    <?php
    // Recupero ticket completo
    $ticket = Ticket::findOne($tempi_item->id_ticket);

    // Recupero operatore
    $operatore = User::findOne($tempi_item->id_operatore);

    if (!$ticket) continue; // evita errori se manca il ticket

    $modalId = 'modalTicket-' . $ticket->id;
    ?>

    <tr>
        <td>
            <!-- Bottone modale -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                <?= Html::encode($ticket->codice_ticket) ?>
            </button>

            <!-- Modale -->
            <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Info ticket <?= Html::encode($ticket->codice_ticket) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p><strong>ID:</strong> <?= Html::encode($ticket->id) ?></p>
                            <p><strong>Codice ticket:</strong> <?= Html::encode($ticket->codice_ticket) ?></p>
                            <p><strong>Problema:</strong> <?= Html::encode($ticket->problema) ?></p>
                            <p><strong>Stato:</strong> <?= Html::encode($ticket->stato) ?></p>
                            <p><strong>Ambito:</strong> <?= Html::encode($ticket->ambito) ?></p>

                            <p><strong>Scadenza:</strong>
                                <?= $ticket->scadenza ? Html::encode($ticket->scadenza) : 'Non definita' ?>
                            </p>

                            <p><strong>Cliente:</strong>
                                <?= Html::encode($ticket->cliente->nome ?? 'N/D') ?>
                            </p>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        </div>

                    </div>
                </div>
            </div>
        </td>

        <td><?= Html::encode($tempi_item->ora_inizio) ?></td>
        <td><?= Html::encode($tempi_item->ora_fine) ?></td>
        <td><?= Html::encode($tempi_item->tempo_lavorazione) ?></td>

        <td>
            <?= Html::encode($operatore ? $operatore->nome . ' ' . $operatore->cognome : 'N/D') ?>
        </td>
    </tr>

<?php endforeach; ?>

    </tbody>
</table>


<?php endif; ?>

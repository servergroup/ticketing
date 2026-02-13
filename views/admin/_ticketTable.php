<?php
use yii\helpers\Html;

/** @var app\models\Ticket[] $ticket */
?>

<?php if (empty($ticket)): ?>
    <p class="text-center mt-4 text-muted">Non ci sono ticket da mostrare.</p>

<?php else: ?>

<table class="table table-hover align-middle mt-4 shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>Codice Ticket</th>
            <th>Azienda</th>
            <th>Problema</th>
            <th>Stato</th>
            <th class="text-center">Azioni</th>
        </tr>
    </thead>

    <tbody>
    <?php foreach ($ticket as $ticket_item): ?>

        <?php
            $modalId = 'modalTicket-' . (int)$ticket_item->id;
            $azienda = $ticket_item->cliente->azienda ?? '-';

            // Badge stato
            $stato = strtolower($ticket_item->stato);
            $badgeClass = match ($stato) {
                'aperto' => 'bg-success',
                'in lavorazione', 'in_lavorazione' => 'bg-warning text-dark',
                'chiuso' => 'bg-secondary',
                default => 'bg-light text-dark'
            };
        ?>

        <tr>
            <!-- CODICE TICKET + MODAL INFO -->
            <td>
                <button type="button"
                        class="btn btn-outline-primary btn-sm fw-bold"
                        data-bs-toggle="modal"
                        data-bs-target="#<?= $modalId ?>">
                    <?= Html::encode($ticket_item->codice_ticket) ?>
                </button>

                <!-- MODAL INFO TICKET -->
                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">

                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">
                                    Ticket <?= Html::encode($ticket_item->codice_ticket) ?>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body">
                                <p><strong>ID:</strong> <?= Html::encode($ticket_item->id) ?></p>
                                <p><strong>Codice:</strong> <?= Html::encode($ticket_item->codice_ticket) ?></p>
                                <p><strong>Azienda:</strong> <?= Html::encode($azienda) ?></p>
                                <p><strong>Problema:</strong> <?= Html::encode($ticket_item->problema) ?></p>
                                <p><strong>Scadenza:</strong> <?= $ticket_item->scadenza ?: 'Non definita' ?></p>
                                <p><strong>Stato:</strong> <?= Html::encode($ticket_item->stato) ?></p>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                            </div>

                        </div>
                    </div>
                </div>
            </td>

            <!-- AZIENDA -->
            <td><?= Html::encode($azienda) ?></td>

            <!-- PROBLEMA -->
            <td><?= Html::encode($ticket_item->problema) ?></td>

            <!-- STATO -->
            <td>
                <span class="badge <?= $badgeClass ?> px-3 py-2">
                    <?= Html::encode($ticket_item->stato) ?>
                </span>
            </td>

            <!-- AZIONI -->
            <td class="text-center">

                <!-- COPIA CODICE -->
                <button class="btn btn-sm btn-outline-secondary btn-copy-ticket"
                        data-code="<?= Html::encode($ticket_item->codice_ticket) ?>">
                    📋
                </button>

                <!-- ELIMINA (APRE MODAL) -->
                <button class="btn btn-sm btn-outline-danger btn-delete-ticket"
                        data-url="<?= Yii::$app->urlManager->createUrl(['ticket/delete-ticket', 'id' => $ticket_item->id]) ?>">
                    🗑️
                </button>

                <!-- MODIFICA -->
                <a class="btn btn-sm btn-outline-primary"
                   href="<?= Yii::$app->urlManager->createUrl(['ticket/modify-ticket', 'codiceTicket' => $ticket_item->codice_ticket]) ?>">
                    ✏️
                </a>

                <!-- ASSEGNAZIONE -->
                <?php if ($stato === 'aperto'): ?>
                    <a class="btn btn-sm btn-outline-success"
                       href="<?= Yii::$app->urlManager->createUrl(['admin/delegate', 'codice_ticket' => $ticket_item->codice_ticket, 'ambito' => $ticket_item->ambito]) ?>">
                        Assegna
                    </a>

                <?php elseif (in_array($stato, ['in lavorazione', 'in_lavorazione'])): ?>
                    <a class="btn btn-sm btn-outline-warning"
                       href="<?= Yii::$app->urlManager->createUrl(['ticket/ritiro', 'codice_ticket' => $ticket_item->codice_ticket, 'ambito' => $ticket_item->ambito]) ?>">
                        Ritira
                    </a>
                <?php endif; ?>

            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php
use yii\helpers\Html;
use yii\helpers\Url;

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
    <?php foreach ($ticket as $ticket_item):
        $azienda = $ticket_item->cliente->azienda ?? '-';
        $statoLower = strtolower((string)$ticket_item->stato);
        if ($statoLower === 'aperto') {
            $badgeClass = 'bg-success';
        } elseif ($statoLower === 'in lavorazione' || $statoLower === 'in_lavorazione') {
            $badgeClass = 'bg-warning text-dark';
        } elseif ($statoLower === 'chiuso') {
            $badgeClass = 'bg-secondary';
        } else {
            $badgeClass = 'bg-light text-dark';
        }
    ?>
        <tr>
            <!-- CODICE TICKET: testo semplice, NESSUN data-bs-toggle -->
            <td class="align-middle">
                <span class="fw-bold ticket-code"><?= Html::encode($ticket_item->codice_ticket) ?></span>
            </td>

            <td class="align-middle"><?= Html::encode($azienda) ?></td>

            <td class="align-middle"><?= Html::encode($ticket_item->problema) ?></td>

            <td class="align-middle">
                <span class="badge <?= Html::encode($badgeClass) ?> px-3 py-2">
                    <?= Html::encode($ticket_item->stato) ?>
                </span>
            </td>

            <td class="text-center align-middle">
                <!-- COPIA CODICE: bottone dedicato -->
                <?= Html::button('📋', [
                    'class' => 'btn btn-sm btn-outline-secondary btn-copy-ticket',
                    'data-code' => $ticket_item->codice_ticket,
                    'title' => 'Copia codice'
                ]) ?>

                <!-- ELIMINA -->
                <?= Html::button('🗑️', [
                    'class' => 'btn btn-sm btn-outline-danger btn-delete-ticket',
                    'data-url' => Url::to(['ticket/delete-ticket', 'id' => $ticket_item->id]),
                    'title' => 'Elimina ticket'
                ]) ?>

                <!-- MODIFICA -->
                <a class="btn btn-sm btn-outline-primary"
                   title="Modifica ticket"
                   href="<?= Url::to(['ticket/modify-ticket', 'codiceTicket' => $ticket_item->codice_ticket]) ?>">
                    ✏️
                </a>

                <!-- ASSEGNAZIONE / RITIRO -->
                <<?php if (
    ($ticket_item->stato === 'in lavorazione' || $ticket_item->stato === 'in_lavorazione')
    && Yii::$app->user->identity->ruolo == 'amministratore'
){?>
                    <a class="btn btn-sm btn-outline-success"
                       href="<?= Url::to(['admin/delegate', 'codice_ticket' => $ticket_item->codice_ticket, 'ambito' => $ticket_item->ambito]) ?>">
                        Assegna
                    </a>
                <?php }else if ($ticket_item->stato ==='in lavorazione' ||  $ticket_item->stato ==='in_lavorazione' && Yii::$app->user->identity->ruolo=='amministratore'){ ?>
                    <a class="btn btn-sm btn-outline-warning"
                       href="<?= Url::to(['ticket/ritiro', 'codice_ticket' => $ticket_item->codice_ticket, 'ambito' => $ticket_item->ambito]) ?>">
                        Ritira
                    </a>
                <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>

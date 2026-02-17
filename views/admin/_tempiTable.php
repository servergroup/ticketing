<?php
use yii\helpers\Html;
use app\models\Ticket;
use app\models\User;

/** @var app\models\TempiTicket[] $tempi */
?>

<?php if (empty($tempi)): ?>
    <p class="text-center mt-4">Nessun risultato trovato.</p>
<?php else: ?>

<table class="table table-hover table-striped align-middle shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>ID Ticket</th>
            <th>Codice Ticket</th>
            <th>Inizio</th>
            <th>Fine</th>
            <th>Durata</th>
            <th>Operatore</th>
            
        </tr>
    </thead>

    <tbody>
        <?php foreach ($tempi as $t): ?>

            <?php
            $ticket = Ticket::findOne($t->id_ticket);
            $operatore = User::findOne($t->id_operatore);

            if (!$ticket) continue;

            $modalContent = "
                <p><strong>ID Ticket:</strong> {$ticket->id}</p>
                <p><strong>Codice:</strong> {$ticket->codice_ticket}</p>
                <p><strong>Problema:</strong> {$ticket->problema}</p>
                <p><strong>Stato:</strong> {$ticket->stato}</p>
                <p><strong>Ambito:</strong> {$ticket->ambito}</p>
                <p><strong>Scadenza:</strong> " . ($ticket->scadenza ?: 'Non definita') . "</p>
                <p><strong>Cliente:</strong> " . ($ticket->cliente->nome ?? 'N/D') . "</p>
            ";
            ?>

            <tr>
                <td class="fw-bold"><?= Html::encode($ticket->id) ?></td>
                <td><?= Html::encode($ticket->codice_ticket) ?></td>

                <td><?= Html::encode($t->ora_inizio) ?></td>
                <td><?= Html::encode($t->ora_fine) ?></td>
                <td><?= Html::encode($t->tempo_lavorazione) ?></td>

                <td><?= Html::encode($operatore ? $operatore->nome . ' ' . $operatore->cognome : 'N/D') ?></td>

               
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

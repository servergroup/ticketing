<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ticket[] $ticket */
?>

<h1 class="text-center">Stato dei miei ticket</h1>
<p class="text-center">Qui vedrai lo stato dei tuoi ticket</p>

<?php if (empty($ticket)): ?>
    <p class="text-center mt-4">Non hai ancora ticket aperti.</p>
<?php else: ?>

<table class="table table-bordered table-striped mt-4">
    <thead class="table-dark">
        <tr>
            <th>Codice Ticket</th>
            <th>Scadenza</th>
            <th>Stato</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($ticket as $ticket_item): ?>
            <tr>
                <td><?= Html::encode($ticket_item->codice_ticket) ?></td>

                <td>
                    <?= Yii::$app->formatter->asDate($ticket_item->scadenza, 'php:d/m/Y') ?>
                </td>

                <td>
                    <?php
                    $colorClass = match ($ticket_item->stato) {
                        'Aperto' => 'badge bg-success',
                        'In lavorazione' => 'badge bg-warning text-dark',
                        'Chiuso' => 'badge bg-danger',
                        default => 'badge bg-secondary',
                    };
                    ?>
                    <span class="<?= $colorClass ?>">
                        <?= Html::encode($ticket_item->stato) ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php
use yii\helpers\Html;
use yii\web\View;
$this->title='Ticket aperti';
/** @var app\models\Ticket[] $ticket */
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

// FLASH INFO
if (Yii::$app->session->hasFlash('info')) {
    $msg = Yii::$app->session->getFlash('info');
    $this->registerJs("
        Swal.fire({
            icon: 'info',
            title: " . json_encode($msg) . ",
            confirmButtonText: 'OK'
        });
    ", View::POS_END);
}
?>

<h1 class="text-center"><?= Html::encode($this->title) ?></h1>

<table class="table table-bordered table-striped mt-4">
    <thead class="table-dark">
        <tr>
            <th>Problema</th>
            <th>Codice Ticket</th>
            <th>Settore</th>
            <th>Azienda</th>
            <th>Azioni</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($ticket as $ticket_item): ?>
            <tr>
                <td><?= Html::encode($ticket_item->problema) ?></td>
                <td>#<?= Html::encode($ticket_item->codice_ticket) ?></td>
                <td><?= Html::encode($ticket_item->ambito) ?></td>
                <td><?= Html::encode($ticket_item->azienda) ?></td>
                <td>
                    <?= Html::a(
                        'Manda in assegnazione',
                        ['admin/delegate', 'codice_ticket' => $ticket_item->codice_ticket, 'ambito' => $ticket_item->ambito],
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

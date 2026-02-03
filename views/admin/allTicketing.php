<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title='Tutti i ticket';
/** @var app\models\Ticket[] $ticket */
/** @var app\models\Ticket $searchTicket */
?>

<h1><?= Html::encode($this->title) ?></h1>


<?php 
$form=ActiveForm::begin();
?>

<?= $form->field($searchTicket,'codice_ticket')->textInput(); ?>

<?php 
ActiveForm::end();
?>
<table class="table table-striped table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Problema</th>
            <th>Codice Ticket</th>
            <th>Settore</th>
            <th>Azienda</th>
            <th>Stato</th>
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
                <td><?= Html::encode($ticket_item->stato) ?></td>
                <?php
                if($ticket_item->stato=='aperto')
                {
                ?>
                
                <td>

                    <?= Html::a('Manda in assegnazione', ['site/index'], ['class' => 'btn btn-primary btn-sm']) ?>
                </td>
                <?php 
                }else{

                
                ?>

                <td></td>
                <?php 
                }
                ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

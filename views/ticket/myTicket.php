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
           <th>Azienda</th>
           <th>problema</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($ticket as $ticket_item): ?>
            <tr>
                <td><?= Html::encode($ticket_item->codice_ticket) ?></td>
                  <?php 
                      $azienda=app\models\User::findOne($ticket_item->id_cliente);

                      
                      ?>

                      <td><?= Html::encode($azienda->azienda) ?></td>


                <td><?= Html::encode($ticket_item->problema) ?></td>
              
                

                <td>
                

                     
                        <?php
                        if($ticket_item->stato=='aperto')
                            {
                        ?>
                        <span class="btn-success">
                        <?= Html::encode('In attesa') ?>
                     
                    </span>
                    <?php
                    }else if($ticket_item->stato=='in lavorazione'){
                    ?>  
                          
                    <span class="btn-warning">
                        <?= Html::encode('In fase di risoluzione') ?>
                    </span>
                    <?php
                    }else{
                    ?>
                      <span class="btn-warning">
                        <?= Html::encode('chiuso') ?>
                    </span>
                    <?php
                            }
                    ?>
                </td>

                <td>
                       <?= Html::a('<img src='.Yii::getAlias('@web/img/delete.png').'>',['ticket/delete-ticket','id'=>$ticket_item->id]) ?>
                    <?= Html::a(
    Html::img(Yii::getAlias('@web/img/pen.png')),
    ['ticket/modify-ticket', 'codiceTicket' => $ticket_item->codice_ticket]
) ?>


                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

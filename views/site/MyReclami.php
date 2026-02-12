<?php 

use yii\helpers\Html;
use app\models\User;
use yii\helpers\Url;

/** @var app\models\Reclamo[] $reclamo */

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<div class="reclamo-container">

    <h2 class="title text-center">Elenco Reclami</h2>

    <table class="table table-bordered table-striped table-hover mt-4">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Azienda</th>
                <th>Reclamo</th>
                <th>Visualizzato</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($reclamo as $reclamo_item): ?>
                <?php 
                    $personale = User::findOne($reclamo_item->id_cliente);
                    $modalId = 'modalReclamo-' . (int)$reclamo_item->id;
                ?>

                <tr>
                    <td><?= Html::encode($reclamo_item->id) ?></td>
                    <td><?= Html::encode($personale->nome ?? 'N/D') ?></td>
                    <td><?= Html::encode($personale->cognome ?? 'N/D') ?></td>
                    <td><?= Html::encode($reclamo_item->azienda) ?></td>

                    <td>
                        <!-- Bottone che apre la modal -->
                        <button type="button" 
                                class="btn btn-link p-0" 
                                data-bs-toggle="modal" 
                                data-bs-target="#<?= $modalId ?>">
                            <?= Html::encode($reclamo_item->problema) ?>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="<?= $modalId ?>Label">
                                            Dettaglio Reclamo #<?= Html::encode($reclamo_item->id) ?>
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">
                                        <p><strong>ID Reclamo:</strong> <?= Html::encode($reclamo_item->id) ?></p>
                                        <p><strong>Azienda:</strong> <?= Html::encode($reclamo_item->azienda) ?></p>
                                        <p><strong>Problema:</strong></p>
                                        <div class="alert alert-secondary">
                                            <?= nl2br(Html::encode($reclamo_item->problema)) ?>
                                        </div>

                                        <?php if (!empty($reclamo_item->descrizione)): ?>
                                            <p><strong>Descrizione completa:</strong></p>
                                            <div class="alert alert-light border">
                                                <?= nl2br(Html::encode($reclamo_item->descrizione)) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="window.location.href='<?= Url::to(['site/visualizzato','codice_ticket'=>$reclamo_item->codice_ticket]) ?>'">Chiudi</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </td>

                    <td>
                        <span class="badge <?= $reclamo_item->visualizzato ? 'bg-success' : 'bg-danger' ?>">
                            <?= $reclamo_item->visualizzato ? 'Sì' : 'No' ?>
                        </span>
                    </td>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>

</div>

<style>
.reclamo-container {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}
</style>

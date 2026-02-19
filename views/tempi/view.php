<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TempiTicket $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tempi Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tempi-ticket-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_ticket',
            'id_operatore',
            'ora_inizio',
            'ora_fine',
            'tempo_lavorazione',
            'pause_effettuate',
            'tempi_pause',
            'ora_pause',
            'chiuso_il',
            'stato',
            'tempo_sospensione',
        ],
    ]) ?>

</div>

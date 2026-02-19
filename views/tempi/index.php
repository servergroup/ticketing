<?php

use app\models\TempiTicket;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tempi Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempi-ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tempi Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_ticket',
            'id_operatore',
            'ora_inizio',
            'ora_fine',
            //'tempo_lavorazione',
            //'pause_effettuate',
            //'tempi_pause',
            //'ora_pause',
            //'chiuso_il',
            //'stato',
            //'tempo_sospensione',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, TempiTicket $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>

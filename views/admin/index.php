<?php

use app\models\Turni;
use yii\helpers\Html;
use app\models\User;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Turnis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="turni-index">

    <h1><?= Html::encode($this->title) ?></h1>

   


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_operatore',
            'entrata',
            'uscita',
            'pausa',
            //'stato',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Turni $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id_operatore]);
                 }
            ],
        ],
    ]); ?>


</div>

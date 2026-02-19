<?php

use app\models\Ticket;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */

/** @var app\models\ticketfunction $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tickets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ticket-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if(Yii::$app->user->identity->ruolo==='amministratore' || Yii::$app->user->identity->ruolo==='cliente'):?>
    <p>
        <?= Html::a('Create Ticket', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php endif; ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 <?= GridView::widget([ 
    'dataProvider' => $dataProvider, 
    'filterModel' => $searchModel, 
    'columns' => [ 
        [
            'class' => 'yii\grid\SerialColumn'
            ],
             'id',
              'problema', 
              'ambito', 
              'codice_ticket', 
              'stato', 
              [ 
                'class' => ActionColumn::className(), 
                'template' => '{view} {update} {delete} {delegate}', 
                'buttons' => [ 'assegna' => function ($url, Ticket $model, $key) {
                    if (Yii::$app->user->identity->ruolo === 'amministratore') { 
                        return Html::a('Ciao', ['admin/delegate', 'id' => $model->id],
                         [ 'title' => 'delegate', 'data-method' => 'post', 'data-confirm' => 'Vuoi assegnare questo ticket?' ]); 
                         }
                          return ''; 
                          }, 
                          ], 
                          'urlCreator' => function ($action, Ticket $model, $key, $index, $column) { 
                            return Url::toRoute([$action, 'id' => $model->id]);
                             } 
                             ],
                              ],
                               ]); ?>


</div>

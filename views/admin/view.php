<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

 use app\models\User;
/** @var yii\web\View $this */
/** @var app\models\Turni $model */

$user=User::findOne($model->id_operatore);
$this->title = $user->nome. ' ' .$user->cognome;
$this->params['breadcrumbs'][] = ['label' => 'Turni', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="turni-view">

    <h1><?= Html::encode( 'Turni di ' . $this->title) ?></h1>

   
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'entrata',
            'uscita',
            'pausa',
            'stato',
        ],
    ]) ?>

</div>

<style>
    h1{
        text-align:center;
    }
</style>
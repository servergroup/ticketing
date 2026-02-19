<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TempiTicket $model */

$this->title = 'Update Tempi Ticket: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tempi Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tempi-ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

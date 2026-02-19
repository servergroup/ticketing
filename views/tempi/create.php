<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TempiTicket $model */

$this->title = 'Create Tempi Ticket';
$this->params['breadcrumbs'][] = ['label' => 'Tempi Tickets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tempi-ticket-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

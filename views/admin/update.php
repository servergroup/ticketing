<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Turni $model */

$this->title = 'Aggiorna Turno #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Turni', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Aggiorna';
?>
<div class="turni-update card-container">

    <div class="card-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="subtitle">Modifica i dati del turno selezionato</p>
    </div>

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>

<style>
.card-container {
    background: #ffffff;
    border-radius: 12px;
    padding: 25px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    max-width: 800px;
    margin: 30px auto;
    border: 1px solid #eaeaea;
}

.card-header h1 {
    font-size: 26px;
    margin-bottom: 5px;
    color: #333;
}

.subtitle {
    font-size: 15px;
    color: #777;
    margin-bottom: 20px;
}

.card-body {
    margin-top: 10px;
}

button.btn-primary,
.btn.btn-success {
    border-radius: 8px !important;
    padding: 10px 18px !important;
    font-size: 15px;
}

.form-control {
    border-radius: 8px !important;
    padding: 10px !important;
    border: 1px solid #ccc;
}

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 6px rgba(74,144,226,0.3);
}
</style>
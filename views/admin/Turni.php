<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="turni-wrapper">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-business-time"></i> Organizzazione Turni
            </h3>
        </div>

        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'entrata')->input('time')->label('Orario Entrata') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'uscita')->input('time')->label('Orario Uscita') ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'pausa')->input('time')->label('Pausa') ?>
                </div>
            </div>

            <div class="form-group mt-3">
                <?= Html::submitButton(
                    'Organizza i turni di ' . Html::encode($personale->nome),
                    ['class' => 'btn btn-primary btn-block']
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
<style>
.turni-wrapper {
    max-width: 650px;
    margin: 0 auto;
    font-family: "Inter", Arial, sans-serif;
}

.card {
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    border: none;
}

.card-header {
    background: #0056b3;
    color: white;
    padding: 18px;
    border-radius: 10px 10px 0 0;
}

.card-title {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.form-control {
    border-radius: 8px !important;
    padding: 10px 12px !important;
    border: 1px solid #d0d0d0 !important;
}

.form-control:focus {
    border-color: #0056b3 !important;
    box-shadow: 0 0 0 3px rgba(0,86,179,0.15) !important;
}

.btn-primary {
    background: #0056b3;
    border: none;
    padding: 12px;
    font-size: 16px;
    border-radius: 8px;
}

.btn-primary:hover {
    background: #003f82;
}
</style>
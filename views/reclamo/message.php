<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Mail $model */
/** @var ActiveForm $form */

$this->title = 'Invia un messaggio';
?>

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <h3 class="mb-4 text-primary fw-semibold">
                Invia un messaggio interno
            </h3>

            <p class="text-muted mb-4">
                Compila il campo sottostante per inviare una comunicazione ai nostri operatori.
            </p>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'mb-3']
            ]); ?>

                <?= $form->field($model, 'messagio')
                    ->textarea([
                        'rows' => 6,
                        'class' => 'form-control form-control-lg',
                        'placeholder' => 'Scrivi qui il tuo messaggio...'
                    ])
                    ->label('Messaggio', ['class' => 'fw-semibold']) ?>

                <div class="mt-4">
                    <?= Html::submitButton('Invia messaggio', [
                        'class' => 'btn btn-primary btn-lg px-4 shadow-sm'
                    ]) ?>
                </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>

<style>
    .card {
        border-radius: 12px;
    }

    .form-control-lg {
        border-radius: 8px;
        padding: 14px;
        font-size: 16px;
    }

    .btn-primary {
        background-color: #0056b3;
        border-color: #004a99;
        border-radius: 8px;
        transition: 0.2s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #004a99;
        border-color: #003d80;
        transform: translateY(-2px);
    }
</style>

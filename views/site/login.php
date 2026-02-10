<?php
use yii\helpers\Html;
use app\assets\LogAsset;
use yii\web\View;

$this->title = '';
LogAsset::register($this);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<div class="login-box">
    <div class="card">
        <div class="login-card-body">

            <p class="login-box-msg">
               <img src="<?= Yii::getAlias('@web/img/taglio_dataseed.svg') ?>" style='width:180px; height:110px;'>
            </p>

            <h1 class="text-center mb-4">Accedi</h1>

            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>

            <!-- USERNAME -->
            <?= $form->field($model, 'username', [
                'template' => '{beginWrapper}{input}{icon}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3'],
                'parts' => [
                    '{icon}' => '
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>'
                ]
            ])->label(false)->textInput(['placeholder' => 'Username']) ?>

            <!-- PASSWORD -->
            <?= $form->field($model, 'password', [
                'template' => '{beginWrapper}{input}{icon}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3'],
                'parts' => [
                    '{icon}' => '
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>'
                ]
            ])->label(false)->passwordInput(['placeholder' => 'Password']) ?>

            <div class="text-center mt-3">
                <?= Html::submitButton('Accedi', [
                    'class' => 'btn btn-primary btn-block'
                ]) ?>
            </div>

            <div class="text-center mt-3">
                <?= Html::a('Hai dimenticato la password?', ['site/mail']) ?>
            </div>

            <div class="text-center mt-2">
                <?= Html::a('Non sei registrato?', ['site/register']) ?>
            </div>

            <?php \yii\bootstrap4\ActiveForm::end(); ?>

        </div>
    </div>
</div>

<style>
body.login-page {
    background: #f4f6f9;
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
}

/* Box login */
.login-box {
    width: 420px;
    max-width: 92%;
    margin: 60px auto;
}

/* Card */
.card {
    border-radius: 12px;
    border: 1px solid #e1e1e1;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    background: #ffffff;
}

.login-card-body {
    padding: 30px;
}

/* Icona sopra */
.login-box-msg {
    font-size: 22px;
    color: #2c3e50;
    text-align: center;
}

/* Input */
.input-group .form-control {
    border-radius: 6px 0 0 6px;
    border: 1px solid #cfcfcf;
    padding: 10px;
    font-size: 15px;
}

.input-group-text {
    background: #f0f0f0;
    border: 1px solid #cfcfcf;
    border-left: none;
    border-radius: 0 6px 6px 0;
}

/* Rimuove icone di validazione Bootstrap */
.form-control.is-valid,
.form-control.is-invalid {
    background-image: none !important;
}

/* Pulsante */
.btn-primary {
    background-color: #0066cc;
    border-color: #005bb5;
    padding: 10px 18px;
    font-size: 15px;
    border-radius: 6px;
    transition: 0.25s;
}

.btn-primary:hover {
    background-color: #005bb5;
    border-color: #004f9e;
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 102, 204, 0.25);
    
}

/* Link */
.login-card-body a {
    color: #0066cc;
    font-weight: 500;
}

.login-card-body a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 480px) {
    .login-card-body {
        padding: 20px;
    }
}
</style>

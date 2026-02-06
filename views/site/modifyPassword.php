<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
$cookie = Yii::$app->request->cookies;

if (Yii::$app->session->hasFlash('success')) {
    $msg = Yii::$app->session->getFlash('success');
    $this->registerJs("
        Swal.fire({
            title: '$msg',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    ");
}

if (Yii::$app->session->hasFlash('error')) {
    $msg = Yii::$app->session->getFlash('error');
    $this->registerJs("
        Swal.fire({
            title: '$msg',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    ");
}
?>

<div class="ds-container">
    <div class="ds-card">
        <h1 class="ds-title">Modifica Password</h1>
        <p class="ds-subtitle">Aggiorna la password del tuo account in modo sicuro</p>

        <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($user, 'email')->textInput([
                'placeholder' => 'Email',
                'type'=>'hidden',
                'value' => $cookie->getValue('recupero'),
                'readonly' => true,
                'class' => 'ds-input'
            ])->label('Email') ?>

            <?= $form->field($user, 'password')->passwordInput([
                'placeholder' => 'Nuova password',
                'class' => 'ds-input'
            ])->label('Nuova password') ?>

            <div class="form-group">
                <?= Html::submitButton('Modifica la password', [
                    'class' => 'ds-btn'
                ]) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>

    /* Contenitore centrale */
.ds-container {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 60px 20px;
}

/* Card */
.ds-card {
    width: 100%;
    max-width: 480px;
    background: #ffffff;
    border-radius: 14px;
    padding: 35px 40px;
    border: 1px solid #e6e6e6;
    box-shadow: 0 6px 22px rgba(0,0,0,0.08);
}

/* Titolo */
.ds-title {
    text-align: center;
    font-size: 26px;
    font-weight: 700;
    color: #1a2a3a;
    margin-bottom: 8px;
}

/* Sottotitolo */
.ds-subtitle {
    text-align: center;
    font-size: 15px;
    color: #6c7a89;
    margin-bottom: 25px;
}

/* Input */
.ds-input {
    border-radius: 8px !important;
    border: 1px solid #cfd6dd !important;
    padding: 10px 12px !important;
    font-size: 15px !important;
}

.ds-input:focus {
    border-color: #0099ff !important;
    box-shadow: 0 0 0 0.2rem rgba(0,153,255,0.25) !important;
}

/* Pulsante aziendale */
.ds-btn {
    background: linear-gradient(135deg, #0066cc, #0099ff);
    border: none;
    color: #fff;
    font-weight: 600;
    padding: 12px 20px;
    border-radius: 8px;
    width: 100%;
    font-size: 16px;
    transition: 0.25s ease;
}

.ds-btn:hover {
    background: linear-gradient(135deg, #005bb5, #0088e6);
    color: #fff;
}

</style>
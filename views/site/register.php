<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

$this->title='';
AppAsset::register($this);
?>

<div class="admin-registerAdmin">

    <h1>Registrazione</h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'nome')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'cognome')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>
        <?= $form->field($user,'email')->input('email') ?>
        <?= $form->field($user,'recapito_telefonico')->textInput(); ?>
        <?= $form->field($user,'ruolo')->dropDownList([
            'cliente' => 'Cliente',
            'ict' => 'operatore(Sistemista)',
            'developer' => 'operatore(Sviluppatore)',
            'amministratore' => 'Amministratore'
           
        ], ['prompt' => 'Seleziona uno dei seguenti ruoli', 'id' => 'ruolo-select']) ?>

         <?= $form->field($user,'immagine')->fileInput(); ?>
        <div id="piva-container" style="display:none;">
            <?= $form->field($user, 'partita_iva')->textInput(['maxlength' => true]) ?>
        </div>
           <div id="azienda" style="display:none;">
            <?= $form->field($user, 'azienda')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
document.getElementById('ruolo-select').addEventListener('change', function() {
    const piva = document.getElementById('piva-container');
    const azienda = document.getElementById('azienda');
    if (this.value === 'cliente') {
        piva.style.display = 'block';
    } else {
        piva.style.display = 'none';
    }

     if (this.value === 'cliente') {
       azienda.style.display = 'block';
    } else {
        azienda.style.display = 'none';
    }
});
</script>


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

        <?= $form->field($user,'ruolo')->dropDownList([
            'itc' => 'ITC',
            'developer' => 'Developer',
            'amministratore' => 'Amministratore',
            'cliente' => 'Cliente'
        ], ['prompt' => 'Seleziona uno dei seguenti ruoli', 'id' => 'ruolo-select']) ?>

        <div id="piva-container" style="display:none;">
            <?= $form->field($user, 'partita_iva')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
document.getElementById('ruolo-select').addEventListener('change', function() {
    const piva = document.getElementById('piva-container');
    if (this.value === 'cliente') {
        piva.style.display = 'block';
    } else {
        piva.style.display = 'none';
    }
});
</script>

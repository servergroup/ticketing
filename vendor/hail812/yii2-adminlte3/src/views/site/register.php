<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
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
            'itc'=>'itc',
            'developer'=>'Developer',
            'amministratore'=>'Ammistratore',
            'cliente'=>'cliente'

        ],['prompt'=>'Seleziona uno dei seguenti ruoli']) ?>

        <div class="form-group">
            <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>


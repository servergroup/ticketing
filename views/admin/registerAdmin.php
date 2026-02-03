<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="admin-registerAdmin">

    <h1>Registrazione Admin</h1>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($user, 'nome')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'cognome')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Registrati', ['class' => 'btn btn-primary']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

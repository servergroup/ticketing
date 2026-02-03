<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $user */
/** @var ActiveForm $form */

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

// SweetAlert per messaggi di ERRORE
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
<div class="admin-modifyPassword">

    <?php $form = ActiveForm::begin(); ?>

    
        <?= $form->field($user, 'username')->textInput() ?>

        <?= $form->field($user, 'password')->passwordInput() ?>
       
    
        <div class="form-group">
            <?= Html::submitButton('Modifica la password', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- admin-modifyPassword -->

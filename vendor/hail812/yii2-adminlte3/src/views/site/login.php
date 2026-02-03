<?php
use yii\helpers\Html;
use app\assets\LogAsset;
use yii\web\View;

$this->title = '';
LogAsset::register($this);


?>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// FLASH SUCCESS
/*
if (Yii::$app->session->hasFlash('success')) {
    $msg = Yii::$app->session->getFlash('success');
    $this->registerJs("
        Swal.fire({
            icon: 'success',
            title: " . json_encode($msg) . ",
            confirmButtonText: 'OK'
        });
    ", View::POS_END);
}
*/
// FLASH ERROR
if (Yii::$app->session->hasFlash('error')) {
    $msg = Yii::$app->session->getFlash('error');
    $this->registerJs("
        Swal.fire({
            icon: 'error',
            title: " . json_encode($msg) . ",
            confirmButtonText: 'OK'
        });
    ", View::POS_END);
}
?>

<div class="login-box">


    <div class="card">
        <div class="login-card-body">

            <p class="login-box-msg">
                <i class="fas fa-ticket-alt"></i> 
            </p>

            <?php $form = \yii\bootstrap4\ActiveForm::begin(['id' => 'login-form']) ?>
            <h1 style="text-align:center;">Accedi</h1>
            <!-- USERNAME -->
            <?= $form->field($model, 'username', [
                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3'],
                'inputTemplate' => '{input}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>',
            ])->label(false)->textInput(['placeholder' => 'Username']) ?>

            <!-- PASSWORD -->
            <?= $form->field($model, 'password', [
                'template' => '{beginWrapper}{input}{error}{endWrapper}',
                'wrapperOptions' => ['class' => 'input-group mb-3'],
                'inputTemplate' => '{input}
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>',
            ])->label(false)->passwordInput(['placeholder' => 'Password']) ?>

         

                <div class="col-4" style="margin-left:130px;">
                    <?= Html::submitButton('Accedi', [
                        'class' => 'btn btn-primary btn-block'
                    ]) ?>
                    
                   
                </div>
            </div>
  <div class="text-center mt-3">
                <?= Html::a('Hai dimenticato la password?', ['site/mail']) ?>
                 
                 
            </div>

              <div class="text-center mt-3">
                 <?= Html::a('Non sei registrato?', ['site/register' ]) ?>
                 
                 
            </div>
            
            <?php \yii\bootstrap4\ActiveForm::end(); ?>

          

        </div>
    </div>
</div>
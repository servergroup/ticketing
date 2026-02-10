<?php

use yii\helpers\Html;
use app\models\User;
use app\models\Turni;
use app\models\userService;
$this->title='';

$function=new userService();
$user=User::findOne(Yii::$app->user->identity->id);
$turni=Turni::findOne(['id_operatore'=>$user->id]);
$function->insertPausa($user->id);
?>
   

<nav class="mobile-navbar d-flex align-items-center justify-content-between px-3">
    <?php if(!Yii::$app->user->isGuest): ?>

        <nav class="main-header navbar navbar-expand navbar-white navbar-light mobile-navbar">
            <ul class="navbar-nav mobile-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <img src="<?= Yii::getAlias('@web/img/menu.png') ?>" style="width:22px;">
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link page-title"><?= Html::encode($this->title) ?></span>
                </li>
            </ul>
        </nav>

        <div style="width: 32px;"></div>

  <?php if ($turni->stato=='In pausa' && Yii::$app->user->identity!='cliente'):?>
     <?= Html::a('Torna in servizio',['site/salta-pausa','id'=>Yii::$app->user->identity->id],['class'=>'btn btn-primary']); ?>
    <?php endif; ?>
        <?= Html::a(
            '<img src="'.Yii::getAlias('@web/img/logout.png').'" style="width:50px;">',
            ['site/logout'],
            ['class'=>'logout']
        ) ?>

    <?php endif; ?>


<?php

if($turni->stato=='In pausa')
    {
        Yii::$app->session->setFlash('info','Sei in pausa');
        $turni->save();
    }
?>
</nav>


<style>
    .logout{
        width:100px;
        height:100px;
    }
</style>

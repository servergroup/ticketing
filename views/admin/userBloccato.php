<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title='Tutti i ticket';
/** @var app\models\User[] $user */

?>

<h1><?= Html::encode($this->title) ?></h1>



<table class="table table-striped table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>Username</th>
            <th>Tentativi</th>
            <th>Approvazione</th>
           
        </tr>
    </thead>

    <tbody>
        <?php foreach ($user as $user_item): ?>
            <tr>
                <td>Username:<?= Html::encode($user_item->username) ?></td>
                <td>password<?= Html::encode($user_item->tentativi) ?></td>
                 <?php
                if(!$user_item->blocco)
                    {
                        ?>
                        <td> Non Bloccato</td>
                       <td><?= Html::a('Approva',['admin/approva','username'=>$user_item->username],['class'=>'btn btn-primary']) ?></td>
                    <?php
                    }else{
                        ?>
                        <td>Bloccato</td>
                         
                        <td> <?= Html::a('Reset',['admin/reset','username'=>$user_item->username],['class'=>'btn btn-primary']) ?></td>
                        <?php
                    }
                ?>
                
           
               
             

                <td></td>
              
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

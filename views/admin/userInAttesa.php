<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title='Ticket in attesa';
/** @var app\models\User[] $user */

?>

<h1><?= Html::encode($this->title) ?></h1>


<?php 

?>
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
                if(!$user_item->approvazione)
                    {
                        ?>
                        <td> Non Approvato</td>
                      <td><?= Html::a('Approva', ['admin/approva', 'username' => $user_item->username],['class'=>'btn-primary']) ?></td>

                    <?php
                    }else{
                        ?>
                        <td> Approvato</td>
                        <td><?= Html::a('Approva', ['admin/approva', 'username' => $user_item->username],['class'=>'btn-primary']) ?></td>
                        <?php
                    }
                ?>
                
           
               
             

                <td></td>
              
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

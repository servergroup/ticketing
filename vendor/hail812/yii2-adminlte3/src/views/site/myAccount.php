<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User  $account */
?>

<style>
    h1{
        text-align: center;
    }

    p{
        text-align: center;
    }
    .ticket-card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #ffffff;
        transition: all .2s ease;
        margin-top:20px;
        gap:20px;
    }
    .ticket-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .ticket-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1f2937;
    }
    .ticket-label {
        font-weight: 500;
        color: #6b7280;
    }
    .badge-corporate {
        background-color: #2563eb;
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: .85rem;
    }
</style>

<h1>Il mio account</h1>

<p>Qui vedrai le informazioni relative al tuo account</p>
<div class="row">

    <div class="col-md-4 col-sm-6 mb-4">
        <div class="ticket-card p-4">
            
            <div class="ticket-title mb-2">
                <p>Username: <?= Html::encode($account->username) ?></p>
            </div>

            <div class="mb-2">
                <p class="ticket-label">ruolo: <?= Html::encode($account->ruolo) ?></p><br>
                <p> Email <?= Html::encode($account->email) ?><h1></h1>
                <p><?= Html::a('Modifica  la password',['site/mail'],['class'=>'btn btn-primary']) ?></p>
                <p><?= Html::a('Modifica  email',['site/modify-username'],['class'=>'btn btn-primary']) ?></p>
            </div>

            
         

        </div>
    </div>

</div>

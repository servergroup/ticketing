<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
    <div class="col-md-6 offset-md-3">
        <div class="ticket-card p-4">

            <table class="table table-bordered">
                <tr>
                    <th>Username</th>
                    <td><?= Html::encode($account->username) ?></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><?= Html::encode($account->email) ?></td>
                </tr>

                <tr>
                    <th>Ruolo</th>
                    <td><?= Html::encode($account->ruolo) ?></td>
                </tr>
            
                   <tr>
                    <th>Parita iva</th>
                    <td><?= Html::encode($account->partita_iva) ?></td>
                    </tr>
            </table>

            <div class="mt-3 text-center">
                  <?= Html::a('Modifica la partita iva', ['site/modify-username'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Modifica email', ['site/modify-username'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Modifica password', ['site/mail'], ['class' => 'btn btn-primary']) ?>
 

<script>
document.getElementById('btnSelectFile').addEventListener('click', function() {
    document.getElementById('hiddenFileInput').click();
});
</script>

            </div>

        </div>
    </div>
</div>

            
         

        </div>
    </div>

</div>

<style>
    .table th {
    width: 30%;
    background: #f3f4f6;
    font-weight: 600;
}

.table td {
    background: #ffffff;
}

</style>
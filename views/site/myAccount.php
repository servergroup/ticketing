<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var yii\web\View $this */
/** @var app\models\User $account */
?>

<style>
/* CONTAINER */
.account-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 25px;
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 28px rgba(0,0,0,0.12);
    font-family: "Inter", Arial, sans-serif;
}

/* FOTO PROFILO */
.profile-pic-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.profile-pic-label {
    cursor: pointer;
    position: relative;
    display: inline-block;
}

/* IMMAGINE PROFILO */
.profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #e5e7eb;
    background: #f3f4f6;
    box-shadow: 0 4px 14px rgba(0,0,0,0.15);
    transition: 0.3s ease;
}

/* HOVER */
.profile-pic-label:hover .profile-pic {
    transform: scale(1.03);
    opacity: 0.85;
}

/* OVERLAY "MODIFICA" */
.edit-overlay {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: rgba(0,0,0,0.55);
    color: white;
    text-align: center;
    padding: 8px 0;
    border-radius: 0 0 50% 50%;
    font-size: 14px;
    opacity: 0;
    transition: 0.3s ease;
}

.profile-pic-label:hover .edit-overlay {
    opacity: 1;
}

/* PLACEHOLDER QUANDO NON C’È IMMAGINE */
.profile-pic.placeholder {
    background: linear-gradient(135deg, #d1d5db, #9ca3af);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

/* CARD */
.ticket-card {
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    background: #ffffff;
    transition: all .2s ease;
    margin-top: 20px;
}

.ticket-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    transform: translateY(-3px);
}

/* TABELLA */
.table th {
    width: 30%;
    background: #f3f4f6;
    font-weight: 600;
}

.table td {
    background: #ffffff;
}

/* BOTTONI */
.btn-primary {
    margin: 6px 0;
    width: 100%;
    border-radius: 10px;
    padding: 10px;
}

/* RESPONSIVE */
@media (max-width: 480px) {
    .account-container {
        padding: 15px;
        box-shadow: none;
    }
    .profile-pic {
        width: 120px;
        height: 120px;
    }
}

</style>

<div class="account-container">

    <!-- FOTO PROFILO MODIFICABILE -->
    <div class="profile-pic-wrapper">
        <label for="upload-img" class="profile-pic-label">
            <img id="preview-img"
                 src="<?= Yii::getAlias('@web/uploads/' . $account->immagine) ?>"
                 alt="Foto profilo"
                 class="profile-pic">

            <div class="edit-overlay">Modifica</div>
        </label>
    </div>

    <h1>Il mio account</h1>
    <p>Qui vedrai le informazioni relative al tuo account</p>

    <div class="ticket-card p-4">

             <!-- FORM PER MODIFICARE L'IMMAGINE -->
            <?php $form = ActiveForm::begin([
                'action' => ['site/modify-image'],
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>


            <?= $form->field($account, 'immagine')->fileInput([
                'accept' => 'image/*',
                'id' => 'upload-img',
                'style' => 'display:none'
            ]) ?>

          <?= Html::submitButton('Modifica immagine',['class'=>'btn btn-primary']) ?>

            <?php ActiveForm::end(); ?>
        <table class="table table-bordered">
            <tr>

        
                <th>Nome</th>
                <td><?= Html::encode($account->nome) ?></td>
            </tr>

            <tr>
                <th>Cognome</th>
                <td><?= Html::encode($account->cognome) ?></td>
            </tr>

            <tr>
                <th>Email</th>
                <td><?= Html::encode($account->email) ?></td>
            </tr>

            <tr>
                <th>Ruolo</th>
                <td><?= Html::encode($account->ruolo) ?></td>
            </tr>

            <?php if (Yii::$app->user->identity->ruolo === 'cliente'): ?>
            <tr>
                <th>Partita IVA</th>
                <td><?= Html::encode($account->partita_iva) ?></td>
            </tr>
            <?php endif; ?>
        </table>

        <div class="mt-3 text-center">

            <!-- Modifica email -->
            <?= Html::a('Modifica email', ['site/modify-email'], ['class' => 'btn btn-primary']) ?>

            <!-- Modifica password -->
            <?= Html::a('Modifica password', ['site/mail'], ['class' => 'btn btn-primary']) ?>

            <!-- Modifica partita IVA SOLO SE CLIENTE -->
            <?php if (Yii::$app->user->identity->ruolo === 'cliente'): ?>
                <?= Html::a('Modifica Partita IVA', ['site/modify-iva'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>

       

        </div>

    </div>

</div>

<script>
/* ANTEPRIMA IMMEDIATA DELL'IMMAGINE */
document.getElementById('upload-img').addEventListener('change', function(event) {
    const img = document.getElementById('preview-img');
    img.src = URL.createObjectURL(event.target.files[0]);
});
</script>

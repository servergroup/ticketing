<?php
use yii\helpers\Html;
use yii\web\View;
$this->title='Ticket assegnati';
/** @var app\models\Assegnazioni $assegnazione */
?>


<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// FLASH SUCCESS
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
<h1><?= Html::encode($this->title) ?></h1>
<div class="ticket-container">



    <div class="ticket-card">
        <div class="ticket-header">
            <h2><?=$assegnazione->codice_ticket ?></h2>
            <span class="ticket-code">#<?= Html::encode($assegnazione->id_operatore) ?></span>
        </div>

        <div class="ticket-body">
           
        
    </div>



</div>


<style>

    /* ==== centro il titolo ====*/

    h1{
        text-align:center;
    }
  /* ====== Palette Aziendale ====== */
:root {
    --primary: #0057b8;
    --primary-dark: #003f88;
    --gray-bg: #f4f6f9;
    --text: #2c3e50;
    --white: #ffffff;
}

/* ====== Base ====== */
body {
    background: var(--gray-bg);
    font-family: "Segoe UI", Roboto, Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: var(--text);
}

/* ====== Container ====== */
.ticket-container {
    max-width: 1100px;
    margin: 40px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
}

/* ====== Card Ticket ====== */
.ticket-card {
    background: var(--white);
    border-radius: 12px;
    border: 1px solid #e1e1e1;
    box-shadow: 0 4px 18px rgba(0,0,0,0.06);
    padding: 25px;
    transition: 0.25s ease;
}

.ticket-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.12);
}

/* ====== Header ====== */
.ticket-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.ticket-header h2 {
    font-size: 20px;
    font-weight: 600;
    color: var(--primary-dark);
    margin: 0;
}

.ticket-code {
    background: var(--primary);
    color: var(--white);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

/* ====== Corpo ====== */
.ticket-body p {
    margin: 8px 0;
    font-size: 15px;
}

/* ====== Responsive ====== */
@media (max-width: 768px) {
    .ticket-header h2 {
        font-size: 18px;
    }

    .ticket-code {
        font-size: 12px;
        padding: 5px 10px;
    }

    .ticket-body p {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .ticket-card {
        padding: 18px;
    }

    .ticket-header h2 {
        font-size: 17px;
    }
}


</style>
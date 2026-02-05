<?php
use app\models\Ticket;
use yii\helpers\Html;
use app\models\User;
use app\models\Assegnazioni;



/** @var app\models\Ticket $ticket */
/** @var app\models\User $user */
/** @var app\models\Ticket $ultimoTicket */
/** @var app\models\Ticket $countTicket */
/** @var app\models\User $assegnazioni */
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>


    
<?php


// Stato da mostrare
$stato = ($countTicket == 0) ? 'Nessun ticket al momento' : $ultimoTicket->stato;
?>

<?php 
if($user->ruolo=='cliente'){
?>
<div class="dashboard-container" oncontextmenu="return false;">

    <!-- HERO -->
    <div class="hero-box">
        <h1>Ciao <?= Yii::$app->user->identity->nome ?> 👋</h1>
        <p>Benvenuto nella tua area personale. Qui puoi monitorare i tuoi ticket, richiederne di nuovi e gestire il tuo profilo.</p>
        <span class="hero-date">Oggi è <?= date("d/m/Y H:i") ?></span>
    </div>

    <!-- STATISTICHE -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info">
                <h3><?= $countTicket ?></h3>
                <p>Ticket Totali</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green"><i class="fas fa-flag"></i></div>
            <div class="stat-info">
                <h3><?= $stato ?></h3>
                <p>Stato Ultimo Ticket</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon orange"><i class="fas fa-user-cog"></i></div>
            <div class="stat-info">
                <h3>Profilo</h3>
                <p>Gestisci le tue credenziali</p>
            </div>
        </div>

    </div>

    <!-- AZIONI PRINCIPALI -->
    <div class="actions-grid">

        <div class="action-card">
            <h2>Richiedi un nuovo ticket</h2>
            <p>Hai bisogno di assistenza? Apri un ticket e il nostro team ti risponderà il prima possibile.</p>
            <?= Html::a('Apri Ticket', ['ticket/new-ticket'], ['class' => 'btn-primary']) ?>
        </div>

        <div class="action-card">
            <h2>Stato dei tuoi ticket</h2>
            <p>Controlla lo stato dei ticket che hai già inviato e monitora l’avanzamento.</p>
            <?= Html::a('Vai ai Ticket', ['ticket/my-ticket'], ['class' => 'btn-success']) ?>
        </div>

    

    </div>

</div>
<?php 
}else if($user->ruolo=='developer'){

foreach ($assegnazioni as $assegnazioni_item) {
    $ticket = Ticket::findOne(['codice_ticket' => $assegnazioni_item->codice_ticket]);
}

$stato = ($countTicket == 0) ? 'Nessun ticket al momento' : 'In lavorazione';
?>




<div class="dashboard-container" oncontextmenu="return false;">

    <!-- HERO -->
    <div class="hero-box">
        <div class="hero-left">
            <h1>Ciao <?= Yii::$app->user->identity->nome ?> 👋</h1>
            <p>Benvenuto nella tua area personale. Qui puoi monitorare i ticket assegnati e lo stato delle attività.</p>
            <span class="hero-date">Oggi è <?= date("d/m/Y H:i") ?></span>
        </div>

        <div class="hero-right">
            <i class="fas fa-user-cog"></i>
        </div>
    </div>

    <!-- STATISTICHE -->
    <div class="stats-grid">

        <!-- CARD 1 -->
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-tasks"></i></div>
            <div class="stat-info">
                <h3><?= $countTicket ?></h3>
                <p>Ticket assegnati a <strong><?= Yii::$app->user->identity->username ?></strong></p>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="stat-card clickable">
            <div class="stat-icon green"><i class="fas fa-folder-open"></i></div>
            <div class="stat-info">
                <h3><?= Html::a('Vai ai ticket', ['operatore/view-ticket'], ['class' => 'stat-link']) ?></h3>
                <p>Gestisci i ticket assegnati</p>
            </div>
        </div>

    </div>

</div>

<?php 
}else if($user->ruolo=='amministratore')
{
    // Ticket dell’utente
$ticket = Ticket::find()->all();

// Conteggio corretto dei ticket dell’utente
$countTicket=Ticket::find()->count();
     ?>
<div class="dashboard-container" oncontextmenu="return false;" >

    <!-- HERO -->
    <div class="hero-box">
        <h1>Ciao <?= Yii::$app->user->identity->nome ?> 👋</h1>
        <p>Benvenuto nell'area degli amminatratori '. Qui puoi monitorare i  ticket in entrata , richiederne di nuovi e gestire il  proprio profilo.</p>
        <span class="hero-date">Oggi è <?= date("d/m/Y H:i") ?></span>
    </div>

    <!-- STATISTICHE -->
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-ticket-alt"></i></div>
            <div class="stat-info">
                <h3><?= $countTicket ?></h3>
                <p>Ticket Totali</p>
            </div>
        </div>



        
    </div>

    <!-- AZIONI PRINCIPALI -->
    <div class="actions-grid">

        <div class="action-card" oncontextmenu="return false;">
            <h2>Richiedi un nuovo ticket</h2>
            <p>Hai bisogno di assistenza? Apri un ticket e il nostro team ti risponderà il prima possibile.</p>
            <?= Html::a('Apri Ticket', ['ticket/new-ticket'], ['class' => 'btn-primary']) ?>
        </div>

        <div class="action-card">
            <h2>Ticket aperti</h2>
            <p>Verifica i ticket che sono ancora aperti ed esenti da lavorazione.</p>
            <?= Html::a('Vai', ['admin/open'], ['class' => 'btn-success']) ?>
        </div>

    

    </div>

</div>
<?php
}else if($user->ruolo=='ict'){
foreach ($assegnazioni as $assegnazioni_item) {
    $ticket = Ticket::findOne(['codice_ticket' => $assegnazioni_item->codice_ticket]);
}

$stato = ($countTicket == 0) ? 'Nessun ticket al momento' : 'In lavorazione';
?>




<div class="dashboard-container" oncontextmenu="return false;">

    <!-- HERO -->
    <div class="hero-box">
        <div class="hero-left" >
            <h1>Ciao <?= Yii::$app->user->identity->nome ?> 👋</h1>
            <p>Benvenuto nella tua area personale. Qui puoi monitorare i ticket assegnati e lo stato delle attività.</p>
            <span class="hero-date">Oggi è <?= date("d/m/Y H:i") ?></span>
        </div>

        <div class="hero-right">
            <i class="fas fa-user-cog"></i>
        </div>
    </div>

    <!-- STATISTICHE -->
    <div class="stats-grid">

        <!-- CARD 1 -->
        <div class="stat-card">
            <div class="stat-icon blue"><i class="fas fa-tasks"></i></div>
            <div class="stat-info">
                <h3><?= $countTicket ?></h3>
                <p>Ticket assegnati a <strong><?= Yii::$app->user->identity->username ?></strong></p>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="stat-card clickable">
            <div class="stat-icon green"><i class="fas fa-folder-open"></i></div>
            <div class="stat-info">
                <h3><?= Html::a('Vai ai ticket', ['operatore/view-ticket'], ['class' => 'stat-link']) ?></h3>
                <p>Gestisci i ticket assegnati</p>
            </div>
        </div>

    </div>

</div>

<?php
}
?>
<style>

/* ====== HERO ====== */
.hero-box {
    background: linear-gradient(135deg, #0057b8, #003f88);
    padding: 35px;
    border-radius: 14px;
    color: #fff;
    margin-bottom: 35px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.hero-box h1 {
    font-size: 32px;
    margin-bottom: 10px;
}

.hero-box p {
    font-size: 16px;
    opacity: 0.9;
}

.hero-date {
    display: inline-block;
    margin-top: 10px;
    padding: 6px 12px;
    background: rgba(255,255,255,0.2);
    border-radius: 6px;
    font-size: 14px;
}

/* ====== STATISTICHE ====== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.stat-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    transition: 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-4px);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 26px;
}

.stat-icon.blue { background: #0057b8; }
.stat-icon.green { background: #28a745; }
.stat-icon.orange { background: #ff9800; }

.stat-info h3 {
    margin: 0;
    font-size: 24px;
    font-weight: bold;
}

.stat-info p {
    margin: 0;
    color: #555;
}

/* ====== ACTIONS ====== */
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
}

.action-card {
    background: #fff;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    transition: 0.25s ease;
}

.action-card:hover {
    transform: translateY(-4px);
}

.action-card h2 {
    margin-bottom: 10px;
    color: #003f88;
}

.action-card p {
    margin-bottom: 15px;
    color: #555;
}

/* ====== BUTTONS ====== */
.btn-primary,
.btn-success,
.btn-warning {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    color: #fff !important;
    font-weight: 600;
    transition: 0.25s ease;
}

.btn-primary { background: #0057b8; }
.btn-primary:hover { background: #003f88; }

.btn-success { background: #28a745; }
.btn-success:hover { background: #1e7e34; }

.btn-warning { background: #ff9800; }
.btn-warning:hover { background: #e68900; }

/* ====== HERO ====== */
.hero-box {
    background: linear-gradient(135deg, #0057b8, #003f88);
    padding: 40px;
    border-radius: 16px;
    color: #fff;
    margin-bottom: 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
}

.hero-left h1 {
    font-size: 34px;
    margin-bottom: 10px;
    font-weight: 700;
}

.hero-left p {
    font-size: 16px;
    opacity: 0.9;
    margin-bottom: 12px;
}

.hero-date {
    display: inline-block;
    padding: 6px 14px;
    background: rgba(255,255,255,0.25);
    border-radius: 8px;
    font-size: 14px;
}

.hero-right i {
    font-size: 70px;
    opacity: 0.25;
}

/* ====== STATISTICHE ====== */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 30px;
}

.stat-card {
    background: #fff;
    padding: 28px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    gap: 22px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    transition: 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.12);
}

.stat-card.clickable {
    cursor: pointer;
}

.stat-icon {
    width: 65px;
    height: 65px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 28px;
}

.stat-icon.blue { background: #0057b8; }
.stat-icon.green { background: #28a745; }

.stat-info h3 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
}

.stat-info p {
    margin: 0;
    color: #555;
    font-size: 15px;
}

.stat-link {
    color: #0057b8;
    font-weight: 700;
    text-decoration: none;
}

.stat-link:hover {
    text-decoration: underline;
}

/* ====== RESPONSIVE ====== */
@media (max-width: 768px) {
    .hero-box {
        flex-direction: column;
        text-align: center;
    }

    .hero-right {
        margin-top: 20px;
    }
}
</style>

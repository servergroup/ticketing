<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\User $user */
/** @var int $countTicket */
/** @var string|null $stato */

$ruolo = $user->ruolo;
$nome  = Yii::$app->user->identity->nome;

// Stato di fallback
$stato = $stato ?? '—';
?>

<div class="dashboard-container">

    <!-- HERO -->
    <div class="hero-box">
        <div class="hero-left">
            <h1>Benvenuto, <?= Html::encode($nome) ?></h1>

            <?php if ($ruolo === 'cliente'): ?>
                <p>Area riservata clienti. Gestisci le tue richieste di assistenza.</p>
            <?php elseif ($ruolo === 'developer' || $ruolo === 'ict'): ?>
                <p>Area operativa. Gestisci i ticket assegnati.</p>
            <?php elseif ($ruolo === 'amministratore'): ?>
                <p>Area amministrativa. Supervisione e gestione ticket.</p>
            <?php endif; ?>

            <span class="hero-date">
                <?= Yii::$app->formatter->asDatetime(time()) ?>
            </span>
        </div>

        <div class="hero-right">
            <i class="fas fa-chart-line"></i>
        </div>
    </div>

    <!-- STATISTICHE -->
    <div class="stats-grid">

        <?php if ($ruolo === 'cliente'): ?>

           <div class="stat-card" onclick="window.location.href='<?= \yii\helpers\Url::to(['site/contact']) ?>'">

                <div class="stat-icon blue"><i class="fas fa-phone"></i></div>
                <div class="stat-info">
                    <h3>Contattaci</h3>
                   
                </div>
            </div>

            <div class="stat-card" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                <div class="stat-icon green"><i class="fas fa-flag"></i></div>
                <div class="stat-info">
                    <h3><?= Html::encode($stato) ?></h3>
                    <p>Stato ultimo ticket</p>
                </div>
            </div>

        <?php elseif ($ruolo === 'developer' || $ruolo === 'ict'): ?>

          

            <div class="stat-card clickable">
                <div class="stat-icon green"><i class="fas fa-folder-open"></i></div>
                <div class="stat-info" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                    <h3>Accedi</h3>
                    <p>Gestione ticket assegnati</p>
                </div>
            </div>

        <?php elseif ($ruolo === 'amministratore'): ?>

            <div class="stat-card" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                <div class="stat-icon blue"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-info">
                    <h3><?= $countTicket ?></h3>
                    <p>Ticket totali in sistema</p>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <!-- AZIONI -->
    <?php if ($ruolo === 'cliente' || $ruolo === 'amministratore'): ?>
        <div class="actions-grid">

            <div class="action-card" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/new-ticket']) ?>'">
                <h2>Nuova richiesta di assistenza</h2>
                <p>Apri un ticket e ricevi supporto dal nostro team.</p>
                <?= Html::a('Apri ticket', ['ticket/new-ticket'], ['class' => 'btn-primary']) ?>
            </div>

            <?php if ($ruolo === 'cliente'): ?>
                <div class="action-card" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                    <h2>I tuoi ticket</h2>
                    <p>Consulta lo stato delle richieste inviate.</p>
                 
                </div>
            <?php endif; ?>

            <?php if ($ruolo === 'amministratore'): ?>
                <div class="action-card"  onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/open']) ?>'">
                    <h2>Ticket aperti</h2>
                    <p>Visualizza e gestisci i ticket in attesa.</p>
                    <?= Html::a('Accedi', ['admin/open'], ['class' => 'btn-success']) ?>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

<!-- STILE AZIENDALE -->
<style>
.dashboard-container {
    max-width: 1200px;
    margin: auto;
}

/* HERO */
.hero-box {
    background: linear-gradient(135deg, #0b3c5d, #062f4f);
    color: #fff;
    padding: 40px;
    border-radius: 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    box-shadow: 0 6px 22px rgba(0,0,0,.15);
}

.hero-left h1 {
    font-size: 32px;
    font-weight: 700;
}

.hero-left p {
    margin-top: 8px;
    opacity: .9;
}

.hero-date {
    margin-top: 12px;
    display: inline-block;
    padding: 6px 14px;
    background: rgba(255,255,255,.2);
    border-radius: 6px;
    font-size: 14px;
}

.hero-right i {
    font-size: 70px;
    opacity: .25;
}

/* GRID */
.stats-grid,
.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 25px;
    margin-bottom: 35px;
}

/* CARDS */
.stat-card,
.action-card {
    background: #fff;
    padding: 28px;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,.08);
    transition: .25s ease;
}

.stat-card:hover,
.action-card:hover {
    transform: translateY(-4px);
}

.stat-card.clickable {
    cursor: pointer;
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
    margin-bottom: 10px;
}

.stat-icon.blue { background: #0b3c5d; }
.stat-icon.green { background: #2e8b57; }

.stat-info h3 {
    font-size: 26px;
    font-weight: 700;
    margin: 0;
}

.stat-info p {
    color: #555;
    margin: 0;
}

/* BUTTONS */
.btn-primary,
.btn-success {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
}

.btn-primary { background: #0b3c5d; }
.btn-primary:hover { background: #062f4f; }

.btn-success { background: #2e8b57; }
.btn-success:hover { background: #256f46; }

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

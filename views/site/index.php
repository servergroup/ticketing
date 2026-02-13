<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Turni;
/** @var app\models\User $user */
/** @var int $countTicket */
/** @var string|null $stato */
if($countTicket>0):
/** @var app\models\Ticket $ultimoTicket */
endif;


$ruolo = $user->ruolo;
$nome  = Yii::$app->user->identity->nome;

// Stato di fallback
$stato = $stato ?? '—';

defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

<div class="dashboard-container">

    <!-- HERO -->
    <div class="hero-box" onclick="window.location.href='<?= Url::to(['site/account']) ?>'">
        <div class="hero-left">
            <h1>Salve, <?= Html::encode($nome) ?></h1>

            <?php if ($ruolo === 'cliente'): ?>
                <p>Area riservata clienti. Gestisci le tue richieste di assistenza.</p>
            <?php elseif ($ruolo === 'developer' || $ruolo === 'ict'): ?>
                <p>Area operativa. Gestisci i ticket assegnati.</p>
            <?php elseif ($ruolo === 'amministratore'): ?>
                <p>Area amministrativa. Supervisione e gestione ticket.</p>
            <?php endif; ?>

          
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

            <?php if($countTicket>0): ?>
          <div class="stat-card" data-bs-toggle="modal" data-bs-target="#ticketModal">
    <div class="stat-icon green"><i class="fas fa-flag"></i></div>
    <div class="stat-info">
        <h3><?= Html::encode($stato) ?></h3>
        <p>Stato ultimo ticket</p>
    </div>
</div>



           
<?php endif; ?>
            <!-- fine modal  !-->
        <?php elseif ($ruolo === 'developer' || $ruolo === 'ict'): ?>

          

            <div class="stat-card clickable">
              
                <div class="stat-icon green"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-info" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                    <h3>Ticket</h3>
                    <p>Gestione ticket assegnati</p>
                </div>

                </div>
  <div class="stat-card clickable">
                 <div class="stat-icon green"><i class="fas fa-envelope"></i></div>
                <div class="stat-info" onclick="window.location.href='<?= \yii\helpers\Url::to(['ticket/my-ticket']) ?>'">
                    <h3>Messagistica</h3>
                    <div>
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
                <div class="action-card"  onclick="window.location.href='<?= \yii\helpers\Url::to(['admin/open']) ?>'">
                    <h2>Ticket aperti</h2>
                    <p>Visualizza e gestisci i ticket in attesa.</p>
                   
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

 <!-- inizio modal !-->

            <div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Stato ultimo ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- Qui puoi caricare contenuto statico o dinamico -->
         <p>Id: <strong><?= Html::encode($ultimoTicket->id) ?></strong></p>
         <p>problema: <strong><?= Html::encode($ultimoTicket->problema) ?></strong></p>
        <p>Stato: <strong><?= Html::encode($ultimoTicket->stato) ?></strong></p>
        <p>Codice ticket: <strong><?= Html::encode($ultimoTicket->codice_ticket) ?></strong></p>
         <p>Data di invio del ticket: <strong><?= Html::encode($ultimoTicket->data_invio) ?></strong></p>

        <!-- Oppure puoi caricare via AJAX -->
        <!-- <div id="modal-content"></div> -->
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
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

.dashboard-container :hover{
transform: translateY(-4px);
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

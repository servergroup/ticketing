<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\models\User $user */
/** @var int $countTicket */
/** @var string|null $stato */
/** @var app\models\Ticket|null $ultimoTicket */

$ruolo = $user->ruolo;
$nome  = Yii::$app->user->identity->nome;
$stato = $stato ?? '—';
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

<div class="dashboard-container">

    <!-- HERO -->
    <div class="hero-box" onclick="window.location.href='<?= Url::to(['site/account']) ?>'">
        <div class="hero-left">
            <h1>Salve, <?= Html::encode($nome) ?></h1>

            <?php if ($ruolo === 'cliente'): ?>
                <p>Area riservata clienti. Gestisci le tue richieste di assistenza.</p>
            <?php elseif (in_array($ruolo, ['developer', 'ict'])): ?>
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

            <div class="stat-card" onclick="window.location.href='<?= Url::to(['site/contact']) ?>'">
                <div class="stat-icon blue"><i class="fas fa-phone"></i></div>
                <div class="stat-info">
                    <h3>Contattaci</h3>
                    <p>Parla con il nostro team di supporto.</p>
                </div>
            </div>

            <?php if ($countTicket > 0 && isset($ultimoTicket)): ?>
                <div class="stat-card" data-bs-toggle="modal" data-bs-target="#ticketModal">
                    <div class="stat-icon green"><i class="fas fa-flag"></i></div>
                    <div class="stat-info">
                        <h3><?= Html::encode($stato) ?></h3>
                        <p>Stato ultimo ticket</p>
                    </div>
                </div>
            <?php endif; ?>

        <?php elseif (in_array($ruolo, ['developer', 'ict'])): ?>

            <div class="stat-card clickable" onclick="window.location.href='<?= Url::to(['ticket/my-ticket']) ?>'">
                <div class="stat-icon green"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-info">
                    <h3>Ticket</h3>
                    <p>Gestione ticket assegnati</p>
                </div>
            </div>

            <div class="stat-card clickable" onclick="window.location.href='<?= Url::to(['ticket/my-ticket']) ?>'">
                <div class="stat-icon blue"><i class="fas fa-envelope"></i></div>
                <div class="stat-info">
                    <h3>Messaggistica</h3>
                    <p>Comunicazioni sui ticket</p>
                </div>
            </div>

        <?php elseif ($ruolo === 'amministratore'): ?>

            <div class="stat-card clickable" onclick="window.location.href='<?= Url::to(['ticket/my-ticket']) ?>'">
                <div class="stat-icon blue"><i class="fas fa-ticket-alt"></i></div>
                <div class="stat-info">
                    <h3><?= (int)$countTicket ?></h3>
                    <p>Ticket totali in sistema</p>
                </div>
            </div>

        <?php endif; ?>

    </div>

    <!-- AZIONI -->
    <?php if (in_array($ruolo, ['cliente', 'amministratore'])): ?>
        <div class="actions-grid">

            <div class="action-card" onclick="window.location.href='<?= Url::to(['ticket/new-ticket']) ?>'">
                <h2>Nuova richiesta di assistenza</h2>
                <p>Apri un ticket e ricevi supporto dal nostro team.</p>
                <?= Html::a('Apri ticket', ['ticket/new-ticket'], ['class' => 'btn-primary']) ?>
            </div>

            <?php if ($ruolo === 'cliente'): ?>
                <div class="action-card" onclick="window.location.href='<?= Url::to(['ticket/my-ticket']) ?>'">
                    <h2>I tuoi ticket</h2>
                    <p>Consulta lo stato delle richieste inviate.</p>
                </div>
            <?php endif; ?>

            <?php if ($ruolo === 'amministratore'): ?>
                <div class="action-card" onclick="window.location.href='<?= Url::to(['admin/open']) ?>'">
                    <h2>Ticket aperti</h2>
                    <p>Visualizza e gestisci i ticket in attesa.</p>
                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>

<?php if ($countTicket > 0 && isset($ultimoTicket)): ?>
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Stato ultimo ticket</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p>Id: <strong><?= Html::encode($ultimoTicket->id) ?></strong></p>
        <p>Problema: <strong><?= Html::encode($ultimoTicket->problema) ?></strong></p>
        <p>Stato: <strong><?= Html::encode($ultimoTicket->stato) ?></strong></p>
        <p>Codice ticket: <strong><?= Html::encode($ultimoTicket->codice_ticket) ?></strong></p>
        <p>Data invio: <strong><?= Html::encode($ultimoTicket->data_invio) ?></strong></p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<style>
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
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
    cursor: pointer;
}

.hero-left h1 {
    font-size: 32px;
    font-weight: 700;
}

.hero-left p {
    margin-top: 8px;
    opacity: .9;
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
    transition: transform .25s ease, box-shadow .25s ease;
}

.stat-card.clickable,
.action-card {
    cursor: pointer;
}

/* SOLO LE CARD SI ALZANO */
.stat-card:hover,
.action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 22px rgba(0,0,0,.18);
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
    font-size: 24px;
    font-weight: 700;
    margin: 0;
}

.stat-info p {
    color: #555;
    margin: 0;
}

/* BUTTONS */
.btn-primary {
    display: inline-block;
    padding: 10px 18px;
    border-radius: 8px;
    color: #fff;
    font-weight: 600;
    text-decoration: none;
    background: #0b3c5d;
    border: none;
}

.btn-primary:hover {
    background: #062f4f;
    color: #fff;
}

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

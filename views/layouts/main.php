<?php
use hail812\adminlte3\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\web\View;
use hail812\adminlte3\assets\FontAwesomeAsset;
FontAwesomeAsset::register($this);

$asset = AdminLteAsset::register($this);
$assetDir = $asset->baseUrl;

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

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
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">

    <!-- NAVBAR MOBILE -->
    <?php if (!Yii::$app->user->isGuest): ?>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light mobile-navbar">
        <ul class="navbar-nav mobile-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <img src="<?= Yii::getAlias('@web/img/menu.png') ?>" style="width:22px;">
                </a>
            </li>
            <li class="nav-item">
                <span class="nav-link page-title"><?= Html::encode($this->title) ?></span>
            </li>
        </ul>
    </nav>
    <?php endif; ?>

    <!-- SIDEBAR -->
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= $this->render('@app/views/layouts/sidebar.php', [
            'assetDir' => $assetDir
        ]) ?>

              <?= $this->render('@app/views/layouts/navbar.php', [
            'assetDir' => $assetDir
        ]) ?>
    <?php endif; ?>

    <!-- CONTENT -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </section>
    </div>

    <!-- FOOTER -->
    <footer class="main-footer">
        <strong>&copy; <?= date('Y') ?> Dataseed.</strong> All rights reserved.
    </footer>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<style>
/* Nascondi navbar su desktop */
.mobile-navbar {
    display: none;
}

/* Mostra navbar su mobile */
@media (max-width: 768px) {
    .mobile-navbar {
        display: flex !important;
        justify-content: space-between;
        padding-left: 10px;
    }

    .mobile-nav {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-title {
        font-weight: 600;
        font-size: 16px;
    }

    /* Riduci larghezza sidebar su mobile */
    .main-sidebar {
        width: 220px !important;
    }

    /* Content più largo su mobile */
    .content-wrapper {
        margin-left: 0 !important;
    }
}
</style>

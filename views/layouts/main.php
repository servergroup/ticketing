<?php
use hail812\adminlte3\assets\AdminLteAsset;
use yii\helpers\Html;
use yii\helpers\Url;

$asset = AdminLteAsset::register($this);
$assetDir = $asset->baseUrl; // necessario per logo e immagini

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

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.all.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.17/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<?php $this->beginBody() ?>

<div class="wrapper">

    <!-- Navbar top -->
          <?= $this->render('@vendor/hail812/yii2-adminlte3/src/views/layouts/navbar.php')?>
    
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="<?= Url::to(['/site/index']) ?>" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <?php if (!Yii::$app->user->isGuest): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/logout']) ?>" data-method="post">
                        Logout (<?= Yii::$app->user->identity->username ?>)
                    </a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= Url::to(['site/login']) ?>">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <!-- Sidebar -->
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= $this->render('@vendor/hail812/yii2-adminlte3/src/views/layouts/sidebar.php', [
            'assetDir' => $assetDir
        ]) ?>
    <?php endif; ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <?= $content ?>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Version 1.0
        </div>
        <strong>&copy; <?= date('Y') ?> Dataseed.</strong> All rights reserved.
    </footer>

</div> <!-- /.wrapper -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

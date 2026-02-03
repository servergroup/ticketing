<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Dataseed</span>
    </a>

    <div class="sidebar">
        <!-- User panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="/site/account " class="d-block">
                    <?= Yii::$app->user->isGuest ? 'Ospite' : Yii::$app->user->identity->username ?>
                </a>
            </div>
        </div>

        <!-- Sidebar menu -->
        <nav class="mt-2">

            <?php
            if(Yii::$app->user->isGuest){
                return;
            }

            $menuItems = [];

            if(Yii::$app->user->identity->ruolo=='amministratore') {
                $menuItems = [

                    ['label' => 'Tutti i ticket', 'icon' => 'fas fa-home', 'url' => ['admin/ticketing']],
                    ['label' => 'Ticket aperti', 'icon' => 'fas fa-exclamation-triangle', 'url' => ['admin/open']],
                    ['label' => 'Ticket chiusi', 'icon' => 'fas fa-check', 'url' => ['admin/scadence']],
                    ['label' => 'Nuovo ticket', 'icon' => 'fas fa-plus', 'url' => ['ticket/new-ticket']],
                    ['label' => 'Nuovo operatore/amministratore', 'icon' => 'fas fa-tags', 'url' => ['site/register']],
                    ['label' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'url' => ['site/logout']],
                ];
            } else if(Yii::$app->user->identity->ruolo=='itc') {
                $menuItems = [
                    ['label' => 'Ticket assegnati', 'icon' => 'fas fa-file-alt', 'url' => ['operatore/view-ticket']],
                    ['label' => 'Info sul tuo account', 'icon' => 'fas fa-list', 'url' => ['site/index']],
                    ['label' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'url' => ['site/logout']],
                ];
            } else if(Yii::$app->user->identity->ruolo=='cliente') {
                $menuItems = [
                    ['label' => 'Nuovo ticket', 'icon' => 'fas fa-plus', 'url' => ['ticket/new-ticket']],
                    ['label' => 'Evoluzione ticket', 'icon' => 'fas fa-history', 'url' => ['ticket/my-ticket']],
                    ['label' => 'Reclama', 'icon' => 'fas fa-comment-dots', 'url' => ['reclamo/reclamo']],
                    ['label' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'url' => ['site/logout']]
                ];
            } else if(Yii::$app->user->identity->ruolo=='developer') {
                $menuItems = [
                    ['label' => 'Ticket assegnati', 'icon' => 'fas fa-file-alt', 'url' => ['operatore/view-ticket']],
                    ['label' => 'Info sul tuo account', 'icon' => 'fas fa-list', 'url' => ['site/index']],
                    ['label' => 'Logout', 'icon' => 'fas fa-sign-out-alt', 'url' => ['site/logout']],
                ];
            }

            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => $menuItems,
            ]);
            ?>
        </nav>
    </div>
</aside>

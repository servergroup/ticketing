<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        
        <span class="brand-text font-weight-light" oncontextmenu="return false;"><img src="<?= Yii::getAlias('@web/img/taglio_dataseed.png') ?>" width="190px"></span>
    </a> 

    <div class="sidebar">

        <!-- User panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <?php
            if(Yii::$app->user->identity->immagine!=null && Yii::$app->user->identity->immagine !='' )
                {
            ?>
            
            <div class="image">
                <img src=<?= Yii::getAlias('@web/img/upload/'.Yii::$app->user->identity->immagine)  ?>
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <?php
}else{
?>
 <div class="image">
                <img src=<?= Yii::getAlias('@web/img/profile.png') ?>
                     class="img-circle elevation-2" alt="User Image">
            </div>

<?php
}
?>
            <div class="info">
                <a href="/site/account" class="d-block">
                    <?= Yii::$app->user->isGuest ? 'Ospite' : Yii::$app->user->identity->username ?>
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            if (Yii::$app->user->isGuest) {
                return;
            }

            $ruolo = Yii::$app->user->identity->ruolo;
            $menuItems = [];

            /* ============================
               AMMINISTRATORE
            ============================ */
            if ($ruolo === 'amministratore') {
                $menuItems = [

                    ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['site/index']],

                    [
                        'label' => 'Ticket',
                        'icon' => 'fas fa-ticket-alt',
                        'items' => [
                            ['label' => 'Tutti i ticket', 'icon' => 'fas fa-list', 'url' => ['admin/ticketing']],
                            ['label' => 'Ticket aperti', 'icon' => 'fas fa-exclamation-circle', 'url' => ['admin/open']],
                            ['label' => 'Ticket chiusi', 'icon' => 'fas fa-check', 'url' => ['admin/scadence']],
                            ['label' => 'Nuovo ticket', 'icon' => 'fas fa-plus', 'url' => ['ticket/new-ticket']],
                        ]
                    ],

                    ['label' => 'Nuovo operatore/amministratore', 'icon' => 'fas fa-user-plus', 'url' => ['site/register']],
                    ['label' => 'Utenti in attesa', 'icon' => 'fas fa-user-clock', 'url' => ['admin/attese']],
                    ['label' => 'Utenti bloccati', 'icon' => 'fas fa-user-slash', 'url' => ['admin/block-user']],
                    
                ];
            }

            /* ============================
               ITC
            ============================ */
            else if ($ruolo === 'itc') {
                $menuItems = [

                    ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['site/index']],

                    [
                        'label' => 'Ticket',
                        'icon' => 'fas fa-ticket-alt',
                        'items' => [
                            ['label' => 'Ticket assegnati', 'icon' => 'fas fa-file-alt', 'url' => ['operatore/view-ticket']],
                        ]
                    ],

                    
                ];
            }

            /* ============================
               CLIENTE
            ============================ */
            else if ($ruolo === 'cliente') {
                $menuItems = [

                    ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['site/index']],

                    [
                        'label' => 'Ticket',
                        'icon' => 'fas fa-ticket-alt',
                        'items' => [
                            ['label' => 'Nuovo ticket', 'icon' => 'fas fa-plus', 'url' => ['ticket/new-ticket']],
                            ['label' => 'Evoluzione ticket', 'icon' => 'fas fa-history', 'url' => ['ticket/my-ticket']],
                        ]
                    ],

                    ['label' => 'Reclama', 'icon' => 'fas fa-comment-dots', 'url' => ['reclamo/reclamo']],
                    
                ];
            }

            /* ============================
               DEVELOPER
            ============================ */
            else if ($ruolo === 'developer') {
                $menuItems = [

                    ['label' => 'Home', 'icon' => 'fas fa-home', 'url' => ['site/index']],

                    [
                        'label' => 'Ticket',
                        'icon' => 'fas fa-ticket-alt',
                        'items' => [
                            ['label' => 'Ticket assegnati', 'icon' => 'fas fa-file-alt', 'url' => ['operatore/view-ticket']],
                        ]
                    ],

                   
                   
                ];
            }

            echo \hail812\adminlte\widgets\Menu::widget([
                'encodeLabels' => false,
                'items' => $menuItems,
            ]);
            ?>

        </nav>
    </div>
</aside>

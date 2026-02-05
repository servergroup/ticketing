<?php
namespace app\assets;

use yii\web\AssetBundle;

class TicketAsset extends AssetBundle
{
    public $sourcePath = '@web';

    public $css = [
       
        'css/ticket.css'
        
    ];

    public $depends = [
        'hail812\adminlte3\assets\AdminLteAsset',
    ];
}

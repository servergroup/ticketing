<?php
namespace app\assets;

use yii\web\AssetBundle;

class TicketAsset extends AssetBundle
{
    public $sourcePath = '@vendor/hail812/yii2-adminlte3/src/web';

    public $css = [
       
        'css/ticket.css'
        
    ];

    public $depends = [
        'hail812\adminlte3\assets\AdminLteAsset',
    ];
}

<?php
namespace app\assets;

use yii\web\AssetBundle;

class LogAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/css';

    public $css = [
       'css/login.css',
        'css/ticket.css',
        'css/register.css'
    ];

    public $depends = [
        'hail812\adminlte3\assets\AdminLteAsset',
    ];
}

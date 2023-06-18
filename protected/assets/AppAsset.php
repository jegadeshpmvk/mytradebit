<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/common.css',
        'css/font-awesome.css',
        'css/fonts.css',
        'css/stylesheet.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\validators\ValidationAsset',
        'yii\widgets\ActiveFormAsset',
        'yii\grid\GridViewAsset',
    ];
}

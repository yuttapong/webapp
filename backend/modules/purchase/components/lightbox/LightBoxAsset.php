<?php
namespace backend\modules\purchase\components\lightbox;

use yii\web\AssetBundle;


class LightBoxAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/purchase/components/lightbox/dist';

    public $css = [
        'lightbox.css'
    ];

    public $js = [
        'lightbox.js'
    ];


    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
<?php
namespace backend\modules\org;

use yii\web\AssetBundle;


class GoJsAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/org/assets';
    /**
     * @inheritdoc
     */
    public $css = [
    ];

    public $js = [
        'js/gojs/go-debug.js',
        'js/chartUpdate.js',
    ];

    public $depends = [
        '\yii\web\JqueryAsset',
    ];

}
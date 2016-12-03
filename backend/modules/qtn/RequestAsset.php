<?php
namespace backend\modules\qtn;

use yii\web\AssetBundle;

class RequestAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/qtn/assets';
    /**
     * @inheritdoc
     */
    public $css = [
    ];

    public $js = [
        'js/requestion.js'
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];

}

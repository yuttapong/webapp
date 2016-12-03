<?php
namespace backend\modules\org;

use yii\web\AssetBundle;


class RequestAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/org/assets';//955b6d2b
    /**
     * @inheritdoc
     */
    public $css = [
    ];

    public $js = [
        'js/position.js',
        'js/node.js'
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];

}

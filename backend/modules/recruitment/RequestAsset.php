<?php
namespace backend\modules\recruitment;

use yii\web\AssetBundle;

class RequestAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@backend/modules/recruitment/assets';
    /**
     * @inheritdoc
     */
    public $css = [
    ];

    public $js = [
        'js/requestion.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];

}

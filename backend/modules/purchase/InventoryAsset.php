<?php

/**
 * Created by PhpStorm.
 * User: RB
 * Date: 22/8/2559
 * Time: 10:00
 */

namespace backend\modules\purchase;

use yii\web\AssetBundle;


class InventoryAsset extends AssetBundle

{

    /**
     * @inheritdoc
     */

    public $sourcePath = '@backend/modules/purchase/assets';
    /**
     * @inheritdoc
     */
    public $css = [

    ];

    public $js = [

    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
    ];

}





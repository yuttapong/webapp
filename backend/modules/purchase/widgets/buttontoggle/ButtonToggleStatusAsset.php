<?php
namespace backend\modules\purchase\widgets\buttontoggle;

use yii\helpers\Html;
use yii\web\AssetBundle;

/**
 * Created by Yuttapong Napikun
 * Email : yuttaponk@gmail.com
 * Date: 17/1/2560
 * Time: 14:04
 */
class ButtonToggleStatusAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/purchase/widgets/buttontoggle/assets';

    public $js = [
        'js/buttontoggle.js',
    ];
    public $css = [

    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
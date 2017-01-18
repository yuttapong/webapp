<?php
namespace backend\modules\purchase\widgets\documentapprove;

use yii\helpers\Html;
use yii\web\AssetBundle;
/**
 * Created by Yuttapong Napikun
 * Email : yuttaponk@gmail.com
 * Date: 17/1/2560
 * Time: 14:04
 */
class DocumentApproveAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/purchase/widgets/documentapprove/assets';

    public $js = [
        'js/js.js',
    ];
    public $css = [
        'css/approve.css',
    ];
    public $depends = [

        'yii\web\JqueryAsset',

    ];

}
<?php
namespace backend\modules\org;

use yii\web\AssetBundle;


class OrgChartAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@vendor/bower/orgchart';
    /**
     * @inheritdoc
     */
    public $css = [
    ];

    public $js = [
        'dist/js/jquery.orgchart.js',
    ];

    public $depends = [
        '\yii\web\JqueryAsset'
    ];

}
<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 21/6/2559
 * Time: 17:52
 */


namespace backend\assets;

use yii\web\AssetBundle;

class MapAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/create_place.js',
    ];
    public $depends = [
    ];
}
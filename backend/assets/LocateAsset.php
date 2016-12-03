<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 21/6/2559
 * Time: 17:38
 */



namespace backend\assets;
use Yii;
use yii\web\AssetBundle;

class LocateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/locate.js',
        'js/geoPosition.js',
        'http://maps.google.com/maps/api/js?key=AIzaSyCS3NrVPgaHRd97Ye-ZBrm5_CJATHwOE2E=',
    ];
    public $depends = [
    ];
}
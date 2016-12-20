<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package   yii2-tree-manager
 * @version   1.0.6
 */

namespace common\siricenter\tree;

use yii\web\AssetBundle;

class TreeAjaxAsset extends AssetBundle
{

    public $js = [
        'js/jquery-1.11.1.min.js',
        'js/jquery-migrate-1.2.1.min.js',
        'js/jquery-ui.js',
        'js/jquery.tree.js',
        'js/hott.js'
    ];
    public $css = ['css/style.css',
        //'http://fonts.googleapis.com/css?family=Cabin:400,700,600'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];

    public function init()
    {
        $this->sourcePath = __DIR__ . "/assets";
        parent::init();
    }


}

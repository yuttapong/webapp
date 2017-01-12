<?php
/**
 * @copyright Copyright (c) 2014 Newerton Vargas de Araújo
 * @link http://newerton.com.br
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace backend\modules\purchase\components\fancybox;

use yii\web\AssetBundle;

class FancyBoxAsset extends AssetBundle
{
    /**
     * Unique value to set an empty asset via Yii AssetManager configuration.
     */
    const EMPTY_ASSET = 'N0/@$$3T$';
    public $sourcePath = '@backend/modules/purchase/components/fancybox';

    public $js = self::EMPTY_ASSET;
    
    public $css = [
        'source/jquery.fancybox.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        if ($this->js === self::EMPTY_ASSET) {
            $this->js = [
                'source/jquery.fancybox.' . (YII_DEBUG ? '' : 'pack.') . 'js',
            ];
        }

        parent::init(); // TODO: Change the autogenerated stub
    }
} 
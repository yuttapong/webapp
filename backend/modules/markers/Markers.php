<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */

namespace app\modules\markers;

use Yii;

class Markers extends \yii\base\Module{
    public $controllerNamespace = 'app\modules\markers\controllers';
    private $_assetsUrl;
	
    public function init()
    {
	parent::init();

        Yii::$app->setComponents(
	    array(
		    'db'=>array(
			'class'=>'yii\db\Connection',
			'tablePrefix' => 'tbl_',
			'dsn'=>'sqlite:'.dirname(__FILE__).'/data/markers.sqlite',
		    ),
	    )
	);
    }
	
    public function getAssetsUrl()
    {
	if($this->_assetsUrl === null)
	{
		$assets = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
		$this -> _assetsUrl = Yii::$app->getAssetManager()->publish($assets, array('beforeCopy' => 
		    function($from, $to)
		    {
			if(strpos($from, '.directory') < 1)
			  return $from;
		    }
		  ));
	}
	    
	return $this->_assetsUrl[1];
    }
}
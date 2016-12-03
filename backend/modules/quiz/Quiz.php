<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */

namespace app\modules\quiz;

use Yii;

class Quiz extends \yii\base\Module{
    public $controllerNamespace = 'app\modules\quiz\controllers';
    private $_assetsUrl;
	
    public function init()
    {
	parent::init();

        Yii::$app->setComponents(
	    array(
		    'db'=>array(
			'class'=>'yii\db\Connection',
			'tablePrefix' => 'tbl_',
			'dsn'=>'sqlite:'.dirname(__FILE__).'/data/quiz.sqlite',
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
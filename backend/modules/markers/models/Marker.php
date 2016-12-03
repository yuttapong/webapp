<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */

namespace app\modules\markers\models;

use Yii;
use yii\db\ActiveRecord;

class Marker extends ActiveRecord
{
    public $maxId = 0;
    	
    /**
      * @return string the associated database table name
      */
    public static function tableName()
    {
	    return '{{%marker}}';
    }
    
    /**
      * @return array validation rules for model attributes.
      */
    public function rules()
    {
	    return array(
		    array(array('longitude', 'latitude', 'text', 'icon'), 'required'),
		    array('text','filter','filter'=>'\yii\helpers\HtmlPurifier::process'),
		    array(array('longitude', 'latitude'), 'integer', 'integerOnly' => false),
	    );
    }

    /**
      * @return array customized attribute labels (name=>label)
      */
    public function attributeLabels()
    {
	    return array(
		    'longitude' => 'Longitude',
		    'latitude' => 'Latitude',
		    'text' => 'Text',
		    'icon' => 'Icon',
	    );
    }
    
    public static function getIcons()
    {
        $strpos = strpos(Yii::$app->controller->module->assetsUrl, 'assets');
        $assets = substr(Yii::$app->controller->module->assetsUrl, $strpos);
        
        $files = scandir($assets . '/images/icons');
        foreach ($files as $key => $value) {
            if ($value == '_license.txt' or $value == '.' or $value === '..' or is_dir($assets . '/images/icons/' . $value))
                unset($files[$key]);
        }
        $files = array_combine($files, $files);
        return $files;
    }
    
    public function beforeSave()
    {
        if($this->scenario == 'insert')
        {
            $marker = Marker::find()
	      ->select('MAX(id) as maxId')
	      ->one();
            $this->id = $marker->maxId + 1;
        }

        return true;
    }
}

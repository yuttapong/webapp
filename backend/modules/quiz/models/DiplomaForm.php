<?php
/**
 * Yii quiz
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.oligalma.com
 * @copyright 2016 Oligalma
 * @license GPL License
 */
 
namespace app\modules\quiz\models;
 
use yii\db\ActiveRecord;
use yii\base\Model;

class DiplomaForm extends Model
{
	public $name;
	
	public function rules()
	{
		return array(
			array('name', 'required'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'=>'Write your name here',
		);
	}
}

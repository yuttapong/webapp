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

class QuizCategory extends ActiveRecord
{
    public $questionCount;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '{{%quiz_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, name', 'required'),
		);
	}

    public function getQuestions()
    {
        return $this->hasMany(QuizQuestion::className(), ['category_id' => 'id']);   
    }
}
<?php

namespace backend\modules\qtn\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "qtn_question_type".
 *
 * @property string $id
 * @property string $type
 * @property string $has_choices
 * @property string $response_table
 *
 * @property QtnQuestion[] $qtnQuestions
 */
class QuestionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_question_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'has_choices', 'response_table'], 'required'],
            [['has_choices'], 'string'],
            [['type', 'response_table'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'has_choices' => 'Has Choices',
            'response_table' => 'Response Table',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(QtnQuestion::className(), ['type_id' => 'id']);
    }
    public function getQuestionType(){
    	$datas = QuestionType::find()
    	->where('status = :status', [':status' => 'Y'])
    	->all();
    	return ArrayHelper::map($datas,'id','type');
    }
}

<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_response_other".
 *
 * @property string $response_id
 * @property string $question_id
 * @property string $choice_id
 * @property string $response
 */
class ResponseOther extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_response_other';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['response_id', 'question_id', 'choice_id'], 'required'],
            [['response_id', 'question_id', 'choice_id','seq'], 'integer'],
            [['response'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'response_id' => 'Response ID',
            'question_id' => 'Question ID',
            'choice_id' => 'Choice ID',
            'response' => 'Response',
            'seq' => 'ลำดับที่',
        ];
    }

    /**
     * @inheritdoc
     * @return ResponseOtherQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponseOtherQuery(get_called_class());
    }
    public function getResponse()
    {
    	return $this->hasOne(Response::className(), ['id' => 'response_id']);
    }
}

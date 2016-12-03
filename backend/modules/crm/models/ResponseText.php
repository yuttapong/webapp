<?php

namespace backend\modules\crm\models;

use Yii;

/**
 * This is the model class for table "qtn_response_text".
 *
 * @property string $response_id
 * @property string $question_id
 * @property string $response
 * @property integer $customer_id
 */
class ResponseText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_response_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['response_id', 'question_id'], 'required'],
            [['response_id', 'question_id'], 'integer'],
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
            'response' => 'Response',
        ];
    }

    /**
     * @inheritdoc
     * @return ResponseTextQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponseTextQuery(get_called_class());
    }

    public function getResponse(){
        return $this->hasOne(Response::className(),['id'=>'response_id']);
    }
}

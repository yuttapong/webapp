<?php

namespace backend\modules\crm\models;
use Yii;

/**
 * This is the model class for table "qtn_response_multiple".
 *
 * @property string $id
 * @property string $response_id
 * @property string $question_id
 * @property string $choice_id
 */
class ResponseMultiple extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'qtn_response_multiple';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['response_id', 'question_id', 'choice_id'], 'required'],
            [['response_id', 'question_id', 'choice_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'response_id' => 'Response ID',
            'question_id' => 'Question ID',
            'choice_id' => 'Choice ID',
        ];
    }

    /**
     * @inheritdoc
     * @return ResponseMultipleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ResponseMultipleQuery(get_called_class());
    }

    public function getQuestion(){
        return $this->hasOne(Question::className(),['id'=>'question_id']);
    }

        public function getResponse()
    {
        return $this->hasOne(Response::className(), ['id' => 'response_id']);
    }
}

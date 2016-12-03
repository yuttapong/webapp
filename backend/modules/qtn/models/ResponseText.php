<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_response_text".
 *
 * @property string $response_id
 * @property string $question_id
 * @property string $response
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property QtnResponse $response0
 * @property QtnQuestion $question
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
            [['response_id', 'question_id', 'created_at', 'created_by'], 'integer'],
            [['response'], 'string'],
            [['response_id'], 'exist', 'skipOnError' => true, 'targetClass' => QtnResponse::className(), 'targetAttribute' => ['response_id' => 'id']],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => QtnQuestion::className(), 'targetAttribute' => ['question_id' => 'id']],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResponse0()
    {
        return $this->hasOne(QtnResponse::className(), ['id' => 'response_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(QtnQuestion::className(), ['id' => 'question_id']);
    }
}

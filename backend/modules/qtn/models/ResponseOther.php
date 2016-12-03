<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_response_other".
 *
 * @property string $response_id
 * @property string $question_id
 * @property string $choice_id
 * @property string $response
 * @property integer $created_at
 * @property integer $created_by
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
            [['response_id', 'question_id', 'choice_id', 'created_at', 'created_by'], 'integer'],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}

<?php

namespace backend\modules\qtn\models;

use Yii;

/**
 * This is the model class for table "qtn_response_multiple".
 *
 * @property string $id
 * @property string $response_id
 * @property string $question_id
 * @property string $choice_id
 * @property integer $created_at
 * @property integer $created_by
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
            [['response_id', 'question_id', 'choice_id', 'created_at', 'created_by'], 'integer'],
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
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}

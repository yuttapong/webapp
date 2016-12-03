<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_response_text".
 *
 * @property string $table_name
 * @property string $table_key
 * @property string $question_id
 * @property string $response
 * @property integer $created_at
 * @property integer $created_by
 */
class ResponseText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_response_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name', 'table_key', 'question_id'], 'required'],
            [['table_key', 'question_id', 'created_at', 'created_by'], 'integer'],
            [['response'], 'string'],
            [['table_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'question_id' => 'Question ID',
            'response' => 'Response',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}

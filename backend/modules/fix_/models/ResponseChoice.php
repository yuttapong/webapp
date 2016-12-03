<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_response_choice".
 *
 * @property string $table_name
 * @property integer $table_key
 * @property string $question_id
 * @property string $choice_id
 * @property string $type
 * @property integer $created_at
 * @property integer $created_by
 */
class ResponseChoice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_response_choice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_name', 'table_key', 'question_id', 'choice_id'], 'required'],
            [['table_key', 'question_id', 'choice_id', 'created_at', 'created_by'], 'integer'],
            [['type'], 'string'],
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
            'choice_id' => 'Choice ID',
            'type' => 'Type',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}

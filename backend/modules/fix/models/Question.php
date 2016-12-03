<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_question".
 *
 * @property string $id
 * @property string $table_name
 * @property string $group_key
 * @property string $name
 * @property string $type_id
 * @property string $log_status
 * @property integer $created_at
 * @property integer $created_by
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type_id'], 'required'],
            [['type_id', 'created_at', 'created_by'], 'integer'],
            [['log_status'], 'string'],
            [['table_name'], 'string', 'max' => 50],
            [['group_key', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_name' => 'Table Name',
            'group_key' => 'Group Key',
            'name' => 'Name',
            'type_id' => 'Type ID',
            'log_status' => 'Log Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }
}

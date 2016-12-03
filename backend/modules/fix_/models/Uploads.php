<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_uploads".
 *
 * @property integer $upload_id
 * @property string $table_name
 * @property string $ref
 * @property string $file_name
 * @property string $real_filename
 * @property string $create_date
 * @property integer $type
 */
class Uploads extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_uploads';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date'], 'safe'],
            [['type'], 'integer'],
            [['table_name'], 'string', 'max' => 100],
           // [['ref'], 'string', 'max' => 50],
            [['file_name', 'real_filename'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'upload_id' => 'Upload ID',
            'table_name' => 'Table Name',
            'ref' => 'Ref',
            'file_name' => 'File Name',
            'real_filename' => 'Real Filename',
            'create_date' => 'Create Date',
            'type' => 'Type',
        ];
    }
}

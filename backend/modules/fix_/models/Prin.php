<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_prin".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property integer $user_order_id
 * @property integer $create_at
 * @property integer $create_by
 * @property integer $site_id
 * @property integer $project_id
 */
class Prin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_prin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['type', 'user_order_id', 'create_at', 'create_by', 'site_id', 'project_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'title' => 'Title',
            'description' => 'Description',
            'type' => 'ประเภทการซื้อ',
            'user_order_id' => 'ผู้สังซื้อ',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'site_id' => 'Site ID',
            'project_id' => 'Project ID',
        ];
    }
    public function getPrinMaterial()
    {
    	return $this->hasMany(PrinDetail::className(), ['prin_id' => 'id']);
    }
}

<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_inventory".
 *
 * @property string $id
 * @property string $categories_id
 * @property string $code
 * @property string $type
 * @property string $name
 * @property integer $basic_unit_id
 * @property string $unit
 * @property string $comment
 * @property integer $status
 * @property integer $create_at
 * @property integer $create_by
 * @property integer $update_at
 * @property integer $update_by
 */
class Inventory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_inventory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['categories_id', 'unit_id','master_id', 'status', 'create_at', 'create_by', 'update_at', 'update_by'], 'integer'],
            [['type', 'comment'], 'string'],
            [['update_at'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['unit_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'categories_id' => 'Categories ID',
            'code' => 'Code',
            'type' => 'Type',
            'name' => 'Name',
            'unit_id' => 'Basic Unit ID',
            'unit_name' => 'Unit',
            'comment' => 'Comment',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
        		'master_id'=> 'master id',
        ];
    }
    public function getInventory()
    {
    	return $this->hasOne(Inventory::className(), ['id' => 'master_id']);
    }
}

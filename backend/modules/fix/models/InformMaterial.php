<?php

namespace backend\modules\fix\models;

use Yii;

/**
 * This is the model class for table "fix_inform_material".
 *
 * @property integer $id
 * @property integer $inventory_id
 * @property integer $inform_job_id
 * @property string $name
 * @property string $qty
 * @property string $unit
 * @property string $price
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $status
 */
class InformMaterial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_inform_material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_id', 'inform_job_id', 'created_at','inform_fix_id', 'created_by', 'status'], 'integer'],
            [['name'], 'required'],
            [['qty', 'price'], 'number'],
            [['name', 'unit'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        	'inform_fix_id' => 'inform_fix_id',
            'inventory_id' => 'Inventory ID',
            'inform_job_id' => 'Inform Job ID',
            'name' => 'Name',
            'qty' => 'Qty',
            'unit' => 'Unit',
            'price' => 'Price',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'status' => 'Status',
        ];
    }
    public function getInformJob()
    {
    	return $this->hasOne(InformJob::className(), ['id' => 'inform_job_id']);
    }
}

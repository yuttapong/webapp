<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "fix_poin_detail".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $site_id
 * @property integer $prin_id
 * @property integer $prin_detail_id
 * @property integer $inventory_id
 * @property string $inventory_name
 * @property double $qty
 * @property integer $unit_id
 * @property integer $unit_name
 * @property double $price
 * @property integer $status
 * @property integer $vendor_id
 * @property integer $home_id
 * @property integer $job_list_id
 * @property string $job_name
 * @property integer $is_deductions
 */
class PoinDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_poin_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'site_id', 'poin_id', 'prin_detail_id', 'inventory_id', 'unit_id',  'status', 'vendor_id', 'home_id', 'job_list_id', 'is_deductions'], 'integer'],
            [['qty', 'price'], 'number'],
            [['inventory_name', 'job_name'], 'string', 'max' => 255],
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
            'project_id' => 'Project ID',
            'site_id' => 'Site ID',
            'poin_id' => 'poin_id ID',
            'prin_detail_id' => 'Prin Detail ID',
            'inventory_id' => 'Inventory ID',
            'inventory_name' => 'Inventory Name',
            'qty' => 'Qty',
            'unit_id' => 'Unit ID',
            'unit_name' => 'Unit Name',
            'price' => 'Price',
            'status' => 'Status',
            'vendor_id' => 'Vendor ID',
            'home_id' => 'Home ID',
            'job_list_id' => 'Job List ID',
            'job_name' => 'Job Name',
            'is_deductions' => 'Is Deductions',
        ];
    }
    public function getUnit()
    {
    	return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
    public function getInventory()
    {
    	return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }
}

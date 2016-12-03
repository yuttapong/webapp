<?php

namespace backend\modules\fix\models;

use Yii;
use backend\modules\purchase\models\Unit;
use backend\modules\purchase\models\Inventory;
use backend\modules\purchase\models\Vendor;
use backend\modules\purchase\models\InventoryPrice;

/**
 * This is the model class for table "fix_prin_detail".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $prin_id
 * @property string $coode_po
 * @property integer $inventory_id
 * @property string $inventory_name
 * @property double $qty
 * @property string $unit
 * @property integer $status
 * @property integer $vendor_id
 * @property integer $home_id
 * @property integer $job_list_id
 * @property string $job_name
 * @property integer $is_deductions
 */
class PrinDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_prin_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'prin_id','unit_id','unit_buy_id', 'inventory_id','is_confirm','inventory_price_id', 'status', 'vendor_id', 'home_id', 'job_list_id', 'is_deductions'], 'integer'],
            [['qty','price'], 'number'],
            [['code_po'], 'string', 'max' => 20],
            [['inventory_name', 'job_name'], 'string', 'max' => 255],
            //[['unit_name'], 'string', 'max' => 100],
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
            'prin_id' => 'Prin ID',
            'code_po' => 'Coode Po',
            'inventory_id' => 'รหัสวัสดุ',
            'inventory_name' => 'ชื่อวัสดุ',
            'qty' => 'จำนวน',
        	'unit_id' => 'Unit id',
            'unit_buy_id' => ' unit_buy_id',
            'status' => 'Status',
            'vendor_id' => 'Vendor ID',
            'home_id' => 'Home ID',
            'job_list_id' => 'Job List ID',
            'job_name' => 'Job Name',
            'is_deductions' => 'Is Deductions',
        	'inventory_price_id'=>'ราคา',
        	'price'=>'ราคา',
        	'is_confirm'=>'ยืนยัน'
        ];
    }
    public function getUnit()
    {
    	return $this->hasOne(Unit::className(), ['id' => 'unit_id']);
    }
    public function getUnitBuy()
    {
    	return $this->hasOne(Unit::className(), ['id' => 'unit_buy_id']);
    }

    public function getInventory()
    {
    	return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }
    public function getVendor()
    {
    	return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }
    public function getInventoryPrice(){
    	return $this->hasOne(InventoryPrice::className(), ['id' => 'inventory_price_id']);
    }
}

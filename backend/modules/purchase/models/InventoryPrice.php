<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_inventory_price".
 *
 * @property string $id
 * @property string $inventory_id
 * @property string $vendor_id
 * @property string $vendor_name
 * @property integer $due_date
 * @property string $price
 * @property integer $type_cost
 * @property string $date_approve
 * @property integer $status
 * @property integer $create_at
 * @property integer $create_by
 * @property integer $type_buy
 */
class InventoryPrice extends \yii\db\ActiveRecord
{
    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_inventory_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['inventory_id', 'vendor_id','price'], 'required'],
            [['inventory_id', 'vendor_id', 'due_date', 'type_cost', 'status', 'create_at', 'create_by', 'type_buy'], 'integer'],
            [['price'], 'number'],
            [['date_approve'], 'safe'],
            [['vendor_name'], 'string', 'max' => 60],
            ['status', 'in', [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inventory_id' => 'Inventory ID',
            'vendor_id' => 'Vendor ID',
            'vendor_name' => 'Vendor Name',
            'due_date' => 'Due Date',
            'price' => 'Price',
            'type_cost' => ' 0 material วัสดุ 1wage ค่าแรง',
            'date_approve' => 'วันที่อนุมัติ',
            'status' => '0 ไม่ใช่งาน 1 ใช้งาน',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'type_buy' => '1 ซื้อตามราน 2 ซื่อ ตาม site งาน',
        ];
    }

    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendor_id']);
    }

    public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'inventory_id']);
    }
}

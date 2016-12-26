<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_inventory_price".
 *
 * @property string $id
 * @property string $inventory_id
 * @property string $vendor_id
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
            [['inventory_id', 'vendor_id', 'due_date', 'type_cost', 'status', 'create_at', 'create_by', 'type_buy'], 'integer'],
            [['price'], 'number'],
            [['date_approve'], 'safe'],
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
            'due_date' => 'Due Date',
            'price' => 'Price',
            'type_cost' => 'Type Cost',
            'date_approve' => 'Date Approve',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'type_buy' => 'Type Buy',
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

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
    public $prices;


    public function init()
    {
        parent::init();

        $this->prices = [
            [
                'price' => '27.0200',
                'vendor_id' => 1,
            ],
            [
                'price' => '27.0200',
                'vendor_id' => 1,
            ],
        ];
    }

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
            [['categories_id', 'unit_id', 'master_id', 'status', 'create_at', 'create_by', 'update_at', 'update_by'], 'integer'],
            [['type', 'comment'], 'string'],
            [['update_at', 'name', 'code', 'unit_id', 'type', 'categories_id'], 'required'],
            [['code', 'id'], 'unique'],
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
            'categories_id' => 'หมวดหมู่',
            'code' => 'Code',
            'type' => 'ประเภท',
            'name' => 'ชื่อสินค้า',
            'unit_id' => 'Basic Unit ID',
            'unit_name' => 'หน่วยนับ',
            'comment' => 'Comment',
            'status' => 'Status',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'update_at' => 'Update At',
            'update_by' => 'Update By',
            'master_id' => 'master id',
        ];
    }

    public function getInventory()
    {
        return $this->hasOne(Inventory::className(), ['id' => 'master_id']);
    }

    public function getCategoriesOfInventory()
    {

    }

    public function getAllPrices()
    {
        $prices = InventoryPrice::find()->where(['inventory_id' => $this->id])->orderBy(['price' => SORT_ASC])->all();
        return $prices;
    }

    public function getAllPricesOnlyActive()
    {
        $prices = InventoryPrice::find()->where(['inventory_id' => $this->id, 'status' => InventoryPrice::STATUS_ACTIVE])->orderBy(['price' => SORT_ASC])->all();
        return $prices;
    }
}

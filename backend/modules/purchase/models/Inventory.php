<?php

namespace backend\modules\purchase\models;

use backend\modules\purchase\InventoryAsset;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Html;
use yii\helpers\Url;

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
    public $imageUpload;
    public $directoryAsset;

    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;

    public function init()
    {

        parent::init();
        $this->directoryAsset = $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/modules/purchase/assets');
        $this->prices = [];
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
            [['categories_id', 'unit_id', 'master_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['type', 'comment'], 'string'],
            [['updated_at', 'name', 'code', 'unit_id', 'type', 'categories_id'], 'required'],
            [['code', 'id'], 'unique'],
            [['code'], 'string', 'max' => 20],
            [['name', 'file_id'], 'string', 'max' => 255],
            [['unit_name'], 'string', 'max' => 50],
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['imageUpload', 'file', 'extensions' => 'jpeg, gif, png'],
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
            'created_at' => 'Create At',
            'created_by' => 'Create By',
            'updated_at' => 'Update At',
            'updated_by' => 'Update By',
            'master_id' => 'master id',
            'file_id' => 'File ID'
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => \backend\modules\purchase\components\uploadfile\UploadBehavior::className(),
                'attribute' => 'photo', // required, use to receive input file
                'savedAttribute' => 'file_id', // optional, use to link model with saved file.
                'uploadPath' => '@common/upload/inventory', // saved directory. default to '@runtime/upload'
                'uploadThumbnailPath' => '@common/upload/inventory/thumbnail', // saved directory. default to '@runtime/upload/thumbnail'
                'autoSave' => true, // when true then uploaded file will be save before ActiveRecord::save()
                'autoDelete' => true, // when true then uploaded file will deleted before ActiveRecord::delete()
                'deleteOldFile' => true,
                'directoryLevel' => 0,
            ],

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

    /**
     * @param $vendorId
     * @return string
     */
    public static function getVendorName($vendorId)
    {
        $vendor = Vendor::findOne($vendorId);
        if ($vendor->company)
            return @$vendor->company;

    }

    public function getImageUrl()
    {
        if ($this->file_id) {
            return Url::to(['file/show', 'id' => $this->file_id]);
        } else {
            return $this->directoryAsset . '/img/product.png';
        }
    }

    public function getImageThumbnailUrl()
    {
        if ($this->file_id) {
            return Url::to(['file/thumbnail', 'id' => $this->file_id]);
        } else {
            return $this->directoryAsset . '/img/product.png';
        }
    }
}

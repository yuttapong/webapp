<?php

namespace common\models;

use Yii;
use backend\modules\crm\models\Customer;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_home".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $home_plan_id
 * @property string $plan_no
 * @property string $home_no
 * @property integer $status
 * @property string $type
 * @property string $home_price
 * @property string $land
 * @property string $use_area
 * @property integer $home_status
 * @property integer $compact_status
 * @property integer $transfer_status
 * @property integer $created_at
 * @property integer $created_by
 */
class Home extends \yii\db\ActiveRecord
{
    // Status Active - สถานะเปิดใช้งาน/ไม่ใช้งาน
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = -1;

    // ฺBooking status - สถานะการจอง
    const STATUS_HOME_READY = 1;
    const STATUS_HOME_RESERVED = 2;


    // constract status - สถานะการทำสัญญาซื้อขาย
    const STATUS_CONTRACT_READY = 1;
    const STATUS_CONTRACT_SUCCESS = 2;


    // transfer status - สถานะการทำเรื่องโอน
    const STATUS_TRANSFER_READY = 1;
    const STATUS_TRANSFER_SUCCESS = 2;


    // ประเภทสิ่งก่อสร้าง
    const TYPE_HOME_SINGLE = 1;
    const TYPE_TOWNHOME = 2;
    const TYPE_TOWNHOUSE = 3;
    const TYPE_HOME_CONDO = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_home';
    }


    public function getStatusItems()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_DELETED => 'Deleted',
        ];
    }

    public function getBookingStatusItems()
    {
        return [
            self::STATUS_HOME_READY => 'ว่าง',
            self::STATUS_HOME_RESERVED => 'จองแล้ว',
        ];
    }

    public function getContractStatusItems()
    {
        return [
            self::STATUS_CONTRACT_READY => 'รอทำสัญญา',
            self::STATUS_CONTRACT_SUCCESS => 'ทำสัญญาแล้ว',
        ];
    }

    public function getTransferStatusItems()
    {
        return [
            self::STATUS_TRANSFER_READY => 'รอโอน',
            self::STATUS_TRANSFER_SUCCESS => 'โอนแล้ว',
        ];
    }

    /**
     * Booking status name
     * @return mixed
     */
    public function getStatusBooking()
    {
        return ArrayHelper::getValue(self::getBookingStatusItems(), $this->home_status);
    }

    /**
     * Contract status name
     * @return mixed
     */
    public function getStatusContract()
    {
        return ArrayHelper::getValue(self::getContractStatusItems(), $this->compact_status);
    }

    /**
     * Transfer status name
     * @return mixed
     */
    public function getStatusTransfer()
    {
        return ArrayHelper::getValue(self::getTransferStatusItems(), $this->transfer_status);
    }


    /**
     *  status name
     * @return mixed
     */
    public function getStatusName()
    {
        return ArrayHelper::getValue(self::getStatusItems(), $this->status);
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'plan_no'], 'required'],
            [['project_id', 'customer_id', 'status', 'home_status', 'compact_status', 'transfer_status', 'created_at', 'created_by'], 'integer'],
            [['type'], 'string'],
            [['home_price', 'land', 'use_area'], 'number'],
            [['plan_no', 'home_no'], 'string', 'max' => 20],
            [['customer_name'], 'string', 'max' => 150],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'โครงการ',
            'plan_no' => 'แปลงที่',
            'home_no' => 'บ้านเลขที่',
            'status' => 'สถานะ',
            'type' => 'ประเภท',
            'home_price' => 'ราคา',
            'land' => 'Land',
            'use_area' => 'Use Area',
            'home_status' => 'สถานะจอง',
            'compact_status' => 'สถานะทำสัญญา',
            'transfer_status' => 'Transfer',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'date_insurance' => 'วันหมดประกัน',
            'customer_id' => 'ลูกค้า',
            'customer_name' => 'ลูกค้า',
            'project.name' => 'Project',
        ];
    }

    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customers_id']);
    }

    public function getProjectItems()
    {
        return ArrayHelper::map(Project::find()
            ->where(['status' => Project::STATUS_ACTIVE])
            ->all(), 'id', 'name');
    }


}

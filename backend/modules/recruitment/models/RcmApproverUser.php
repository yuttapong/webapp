<?php

namespace backend\modules\recruitment\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "rcm_approver_user".
 *
 * @property integer $id
 * @property integer $document_id
 * @property integer $table_name
 * @property integer $manpower_id
 * @property integer $user_id
 * @property integer $user_code
 * @property string $position_name
 * @property string $comment
 * @property string $app_status
 * @property string $user_type
 * @property integer $seq
 * @property integer $created_at
 * @property integer $created_by
 */
class RcmApproverUser extends \yii\db\ActiveRecord
{

    //type of user
    const TYPE_REQUEST = 'REQUEST';
    const  TYPE_APPROVER = 'APPROVER';


    //status
    const STATUS_PENDING = 'PENDING';
    const STATUS_APPROVED = 'APPROVED';
    const  STATUS_DISAPPROVED = 'DISAPPROVED';


    /***
     * ัวแปรเก็บสถานะว่าอนุมัติเอกสารครบหรือไม่ครบ
     * อยู่แบบฟอร์มอนุมัติ
     * ค่าจะเป็น  0  : ถ้าอนุมัติยังไม่ครบ
     * ค่าจะเป็น  1 : ถ้าคนสุดท้ายอนุมัติ
     */
    public $is_complete;



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'ref_id', 'user_id', 'user_code', 'seq', 'created_at', 'created_by', 'updated_at', 'updated_by','is_complete'], 'integer'],
            [['ref_id', 'user_code', 'created_at', 'app_status', 'user_type'], 'required'],
            [['table_name', 'comment', 'app_status', 'user_type', 'table_name'], 'string'],
            [['position_name'], 'string', 'max' => 255],
        ];
    }


    /**
     * @param $key
     * @return mixed
     */
    public function getItems($key)
    {
        $items = [
            'status' => [
                self::STATUS_APPROVED => 'อนุมัติ',
                self::STATUS_DISAPPROVED => 'ไม่อนุมัติ',
            ]
        ];
        return ArrayHelper::getValue($items, $key);
    }

    /**
     * @return mixed
     */
    public function getStatusItems()
    {
        return [
            self::STATUS_APPROVED => 'อนุมัติ',
            self::STATUS_DISAPPROVED => 'ไม่อนุมัติ',
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_approver_user';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'document_id' => Yii::t('app', 'Document ID'),
            'table_name' => Yii::t('app', 'Table Name'),
            'ref_id' => Yii::t('app', 'Ref ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_code' => Yii::t('app', 'รหัสพนักงาน'),
            'position_name' => Yii::t('app', 'ตำแหน่ง'),
            'comment' => Yii::t('app', 'ความคิดเห็น'),
            'app_status' => Yii::t('app', 'สถานะการอนุมัติ'),
            'user_type' => Yii::t('app', 'ประเภทรายการอนุมัติ'),
            'seq' => Yii::t('app', 'ลำดับอนุมัติ'),
            'created_at' => Yii::t('app', 'วันที่สร้าง'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
            'updated_at' => Yii::t('app', 'แก้ไขล่าสุด'),
            'updated_by' => Yii::t('app', 'แก้ไขโดย'),
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }
}

<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "org_personnel".
 *
 * @property string $id
 * @property string $user_id
 * @property string $code
 * @property integer $prefix_id
 * @property string $prefix_name_th
 * @property string $firstname_th
 * @property string $lastname_th
 * @property string $nickname
 * @property string $prefix_name_en
 * @property string $firstname_en
 * @property string $lastname_en
 * @property string $middlename_th
 * @property string $middlename_en
 * @property string $birthday
 * @property integer $day_probation
 * @property string $work_status
 * @property string $work_type
 * @property string $military_status
 * @property integer $status
 * @property string $nationality
 * @property string $race
 * @property string $religion
 * @property string $idcard
 * @property string $blood
 * @property string $living_status
 * @property string $marriage_status
 * @property integer $idcard_province_id
 * @property integer $idcard_amphur_id
 * @property string $idcard_date_expiry
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $active
 * @property string $photo
 * @property double $weight
 * @property double $height
 * @property string $start_working
 */
class Personnel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'prefix_id', 'day_probation', 'status', 'idcard_province_id', 'idcard_amphur_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active'], 'integer'],
            [['birthday', 'idcard_date_expiry', 'start_working'], 'safe'],
            [['blood', 'living_status', 'marriage_status'], 'string'],
            [['weight', 'height'], 'number'],
            [['code'], 'string', 'max' => 11],
            [['prefix_name_th', 'prefix_name_en'], 'string', 'max' => 50],
            [['firstname_th', 'lastname_th', 'firstname_en', 'lastname_en', 'middlename_th', 'middlename_en'], 'string', 'max' => 60],
            [['nickname'], 'string', 'max' => 30],
            [['work_status', 'work_type', 'military_status', 'nationality', 'race', 'religion', 'idcard'], 'string', 'max' => 20],
            [['photo'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'code' => 'รหัสพนักงาน',
            'prefix_id' => 'คำนำหน้า',
            'prefix_name_th' => 'คำนำหน้า',
            'firstname_th' => 'ซื่อ',
            'lastname_th' => 'นามสกุล',
            'nickname' => 'ชื่อเล่น',
            'prefix_name_en' => 'คำนำหน้า',
            'firstname_en' => 'Firstname',
            'lastname_en' => 'Lastname',
            'middlename_th' => 'ชื้อกลางไว้ใส่ชื่อเล่น',
            'middlename_en' => 'ชื้อกลางไว้ใส่ชื่อเล่น',
            'birthday' => 'วันเกิด',
            'day_probation' => 'จำนวนวันที่ทดลองาน',
            'work_status' => 'พ้นสภาพ,พักงาน,ทำงานอยู่',
            'work_type' => 'ทดลองงาน,ชั่วคราว,นักศึกษาฝึกงาน,สมัครงาน,พนักงานประจำ',
            'military_status' => 'สถานะภาพทางทหาร',
            'status' => 'Status',
            'nationality' => 'สัญชาติ',
            'race' => 'เชื้อชาติ',
            'religion' => 'ศาสนา',
            'idcard' => 'บัตรประชาชน',
            'blood' => 'กลุ่มเลือด',
            'living_status' => 'สถานะความเป็นอยู่',
            'marriage_status' => 'สถานภาพสมรส',
            'idcard_province_id' => 'จังวัดที่ออกบัตi',
            'idcard_amphur_id' => 'ออกให้ ณ เขต/อำเภอ',
            'idcard_date_expiry' => 'Idcard Date Expiry',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'active' => 'Active',
            'photo' => 'Photo',
            'weight' => 'น้ำหนัก',
            'height' => 'ส่วนสูง',
            'start_working' => 'Start Working',
        ];
    }

    public function getFullnameTH()
    {
        return @$this->firstname_th . ' ' . $this->lastname_th;
    }
}

<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "general_address".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $company
 * @property string $no
 * @property string $soi
 * @property string $moo
 * @property string $village
 * @property string $road
 * @property integer $province_id
 * @property integer $tambon_id
 * @property integer $amphur_id
 * @property string $zipcode
 * @property string $table_name
 * @property integer $table_key
 * @property integer $created_at
 * @property integer $created_by
 */
class GeneralAddress extends \yii\db\ActiveRecord
{

    const TYPE_OFFICE = 'office';
    const TYPE_HOUSE = 'house';
    const TYPE_CONTACT = 'contact';
    const TYPE_HOME = 'home';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'general_address';
    }

    /**
     * @inheritdoc
     * @return GeneralAddressQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GeneralAddressQuery(get_called_class());
    }

    /**
     * ประเภทที่อยู่
     * @return array
     */
    public static function getTypeItems()
    {
        $items = [
            self::TYPE_CONTACT => 'ที่อยู่ปัจจุบัน',
            self::TYPE_OFFICE => 'ที่ทำงาน',
            //self::TYPE_HOME => 'บ้าน',
            // self::TYPE_HOUSE => 'ห้องเช่า/หอพัก',
        ];

        return $items;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string'],
            [['province_id', 'tambon_id', 'amphur_id', 'table_key', 'created_at', 'created_by', 'active'], 'integer'],
            [['name', 'company'], 'string', 'max' => 60],
            [['no', 'moo'], 'string', 'max' => 20],
            [['soi', 'village'], 'string', 'max' => 50],
            [['road'], 'string', 'max' => 100],
            [['zipcode'], 'string', 'max' => 10],
            [['table_name'], 'string', 'max' => 255],
            [['is_default'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'ประเภทที่อยู่',
            'name' => 'ชื่อที่อยู่',
            'company' => 'บริษัท',
            'no' => 'เลขที่',
            'soi' => 'ซอย',
            'moo' => 'หมู่ที่',
            'village' => 'หมู่บ้าน',
            'road' => 'ถนน',
            'province_id' => 'จังหวัด',
            'tambon_id' => 'ตำบล',
            'amphur_id' => 'อำเภอ',
            'zipcode' => 'รหัสไปรษณีย์',
            'table_name' => 'Table Name',
            'table_key' => 'Table Key',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'active' => 'Active',
            'typeName' => 'ประเภทที่อยู่',
            'is_default' => 'ตั้งเป็นที่อยู่เริ่มต้น (Default)',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),

        ];
    }

    /**
     * ชื่อประเภทที่อยู่
     * @return mixed
     */
    public function getTypeName()
    {
        return ArrayHelper::getValue($this->typeItems, $this->type);
    }

    /**
     * ค่าอำเภอเริ่มต้น
     * @return array
     */
    public function getAmphurValue()
    {
        return ArrayHelper::map(SysAmphur::findAll(['id' => $this->amphur_id]), 'id', 'name_th');
    }

    /**
     * ค่าตำแบลเริ่มต้น
     * @return array
     */
    public function getTambonValue()
    {
        return ArrayHelper::map(SysTambon::findAll(['id' => $this->tambon_id]), 'id', 'name_th');
    }

    /**
     * ข้อมูลจังหวัดทั้งหมด
     * @return \yii\db\ActiveQuery
     */
    public function getProvince()
    {
        return @$this->hasOne(SysProvince::className(), ['id' => 'province_id']);
    }

    public function getAmphur()
    {
        return @$this->hasOne(SysAmphur::className(), ['id' => 'amphur_id']);
    }

    public function getTambon()
    {
        return @$this->hasOne(SysTambon::className(), ['id' => 'tambon_id']);
    }
}

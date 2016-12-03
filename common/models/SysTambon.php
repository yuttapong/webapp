<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_tambon".
 *
 * @property integer $id
 * @property integer $province_id
 * @property integer $amphur_id
 * @property string $code
 * @property string $name_th
 * @property string $amphur_code
 * @property string $province_code
 * @property integer $geography_id
 * @property string $zip_cpde
 * @property integer $active
 * @property string $master_id
 * @property integer $created_at
 * @property integer $created_by
 */
class SysTambon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_tambon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'province_id', 'amphur_id', 'geography_id', 'active', 'created_at', 'created_by'], 'integer'],
            [['code', 'amphur_code', 'province_code'], 'string', 'max' => 20],
            [['name_th'], 'string', 'max' => 255],
            [['zip_cpde'], 'string', 'max' => 10],
            [['master_id'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'province_id' => 'Province ID',
            'amphur_id' => 'Amphur ID',
            'code' => 'Code',
            'name_th' => 'ตำบล',
            'amphur_code' => 'Amphur Code',
            'province_code' => 'Province Code',
            'geography_id' => 'Geography ID',
            'zip_cpde' => 'รหัสไปรษณีย์',
            'active' => 'Active',
            'master_id' => 'Master ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * @inheritdoc
     * @return SysTambonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysTambonQuery(get_called_class());
    }

    public function getGeo()
    {
        return $this->hasOne(SysGeography::className(), ['id' => 'geography_id']);
    }

    public function getProvince()
    {
        return $this->hasOne(SysProvince::className(), ['id' => 'province_id']);
    }

    public function getAmphur()
    {
        return $this->hasOne(SysAmphur::className(), ['id' => 'amphur_id']);
    }

}

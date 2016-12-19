<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_province".
 *
 * @property integer $id
 * @property string $code
 * @property string $name_th
 * @property string $name_en
 * @property integer $active
 * @property integer $geography_id
 * @property integer $created_at
 * @property integer $created_by
 */
class SysProvince extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_province';
    }

    /**
     * @inheritdoc
     * @return SysProvinceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysProvinceQuery(get_called_class());
    }

    public  function getCountAmphur()
    {
        return count($this->amphurs);
    }

    public  function getCountTambon()
    {
        return count($this->tambons);
    }

    public static function getArrayProvince()
    {
        $model = SysProvince::find()
            ->orderBy(['name_th' => SORT_ASC])
            ->all();
        return ArrayHelper::map($model, 'id', 'name_th');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name_th', 'code', 'active'], 'required'],
            [['id', 'active', 'geography_id', 'created_at', 'created_by'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name_th', 'name_en'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name_th' => 'ชื่อจังหวัด',
            'name_en' => 'ชื่อจังหวัด(อังกฤษ)',
            'active' => 'Active',
            'geography_id' => 'ภาค',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'geography.name_th' => 'ภาค',
        ];
    }

    public function getGeography()
    {
        return $this->hasOne(SysGeography::className(), ['id' => 'geography_id']);
    }

    public function getAmphurs()
    {
        return $this->hasMany(SysAmphur::className(), ['province_id' => 'id']);
    }

    public function getTambons()
    {
        return $this->hasMany(SysTambon::className(), ['province_id' => 'id']);
    }
}

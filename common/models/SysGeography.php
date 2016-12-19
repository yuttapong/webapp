<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_geography".
 *
 * @property integer $id
 * @property string $code
 * @property string $name_th
 * @property string $name_en
 * @property integer $active
 * @property integer $create_time
 * @property integer $create_by
 */
class SysGeography extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_geography';
    }

    /**
     * @inheritdoc
     * @return SysGeographyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysGeographyQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code'], 'required'],
            [['id', 'active', 'create_time', 'create_by'], 'integer'],
            [['code'], 'string', 'max' => 2],
            [['name_th', 'name_en'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'code' => 'Code',
            'name_th' => 'ชื่อ',
            'name_en' => 'ชื่อ(อังกฤษ)',
            'active' => 'Active',
            'create_time' => 'Create Time',
            'create_by' => 'Create By',
        ];
    }

    public function getProvinces()
    {
        return $this->hasMany(SysProvince::className(), ['geography_id' => 'id']);
    }

    public function getAmphurs()
    {
        return $this->hasMany(SysAmphur::className(), ['geography_id' => 'id']);
    }


    public function getTambons()
    {
        return $this->hasMany(SysTambon::className(), ['geography_id' => 'id']);
    }


    public function getCountProvince()
    {
        return count($this->provinces);
    }

    public function getCountAmphur()
    {
        return count($this->amphurs);
    }

    public function getCountTambon()
    {
        return count($this->tambons);
    }

    public static  function getArrayGeoGraphy()
    {
        $model = SysGeography::find()->all();
        return ArrayHelper::map($model, 'id', 'name_th');
    }
}

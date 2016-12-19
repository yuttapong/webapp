<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_amphur".
 *
 * @property integer $id
 * @property string $code
 * @property string $name_th
 * @property integer $geography_id
 * @property string $province_code
 * @property integer $active
 * @property string $master_id
 * @property integer $create_at
 * @property integer $create_by
 */
class SysAmphur extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_amphur';
    }

    /**
     * @inheritdoc
     * @return SysAmphurQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysAmphurQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'geography_id', 'province_id', 'active', 'create_at', 'create_by'], 'integer'],
            [['code', 'province_code', 'master_id'], 'string', 'max' => 20],
            [['name_th'], 'string', 'max' => 150],
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
            'name_th' => 'อำเภอ',
            'geography_id' => 'ภาค',
            'province_code' => 'จังหวัด',
            'province_id' => 'จังหวัด',
            'active' => 'Active',
            'master_id' => 'Master ID',
            'create_at' => 'Create At',
            'create_by' => 'Create By',
            'geography.name_th' => 'ภาค',
            'province.name_th' => 'จังหวัด',

        ];
    }

    public function getGeography()
    {
        return $this->hasOne(SysGeography::className(), ['id' => 'geography_id']);
    }

    public function getProvince()
    {
        return $this->hasOne(SysProvince::className(), ['id' => 'province_id']);
    }
}

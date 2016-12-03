<?php

namespace backend\modules\recruitment\models;

use Yii;

/**
 * This is the model class for table "rcm_setting".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $description
 */
class RcmSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rcm_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['value', 'description'], 'string'],
            [['name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'description' => 'Description',
        ];
    }

    public function getSetting($name){
        $model =  RcmSetting::findOne(['name'=>$name]);
        if($model)
            return $model->value;
    }

    public function saveSetting($name,$val){
        $model = RcmSetting::findOne(['name'=>$name]);
        $model->value = $val;
        if($model->save()){
            return true;
        }else{
            return false;
        }

    }
}

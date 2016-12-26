<?php

namespace backend\modules\purchase\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "psm_unit".
 *
 * @property string $id
 * @property string $name
 * @property integer $status
 */
class Unit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'status' => 'Status',
        ];
    }
    public static function getDataList(){
    	$dataUnit = Unit::find()
    	->select('id, name')
    	->indexBy('id')
    	->where(['status'=>1])
    	->orderBy('name')
    	->all();
    	return ArrayHelper::map($dataUnit, 'id', 'name');
    
    }
}

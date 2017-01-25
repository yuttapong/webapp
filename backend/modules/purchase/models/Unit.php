<?php

namespace backend\modules\purchase\models;

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

    public static function getDataList()
    {
        $dataUnit = Unit::find()
            ->select('id, name')
            ->indexBy('id')
            ->where(['status' => 1])
            ->orderBy('name')
            ->all();
        return ArrayHelper::map($dataUnit, 'id', 'name');

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 60],
            [['name'], 'unique']
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
}

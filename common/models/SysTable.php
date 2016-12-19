<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sys_table".
 *
 * @property integer $id
 * @property string $name
 * @property string $detail
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 */
class SysTable extends \yii\db\ActiveRecord
{
    const   TYPE_DATA = 'DATA';
    const  TYPE_TABLE = 'TABLE';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'name'], 'required'],
            [['detail', 'slug'], 'string'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'slug' => Yii::t('app', 'Slug'),
            'name' => Yii::t('app', 'ชื่อ'),
            'detail' => Yii::t('app', 'รายละเอียด'),
            'status' => Yii::t('app', 'สถานะ'),
            'created_at' => Yii::t('app', 'สร้างเมื่อ'),
            'created_by' => Yii::t('app', 'สร้างโดย'),
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
     * @return $this
     */
    public function getSysBasicDatas()
    {
        return $this->hasMany(SysBasicData::className(), ['table_id' => 'id'])
            ->where(['status' => SysBasicData::STATUS_ACTIVE])
            ->orderBy(['sorter' => SORT_ASC]);
    }


    /**
     * @return array
     */
    public function getTableList()
    {
        $model = SysTable::find()->all();
        return ArrayHelper::map($model, 'id', 'name');
    }


    /**
     * @param $slug
     * @return array
     */
    public function getBasicDataList($slug)
    {
        if ($slug) {
            $model = SysTable::find()
                ->where(['slug' => $slug, 'type' => SysTable::TYPE_DATA])
                ->one();
            return ArrayHelper::map($model->sysBasicDatas, 'id', 'name');
        } else {
        }
        return [];

    }


}

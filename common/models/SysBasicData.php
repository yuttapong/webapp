<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "sys_basic_data".
 *
 * @property integer $id
 * @property integer $table_id
 * @property string $code
 * @property string $name
 * @property integer $status
 * @property integer $create_at
 * @property integer $create_id
 * @property integer $is_deleted
 *
 * @property SysTable $table
 * @property SysModule[] $sysModules
 */
class SysBasicData extends \yii\db\ActiveRecord
{
    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_basic_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table_id', 'status', 'created_at', 'created_by', 'is_deleted', 'sorter'], 'integer'],
            [['code','name','status'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 255],
            [['table_id'], 'exist', 'skipOnError' => true, 'targetClass' => SysTable::className(), 'targetAttribute' => ['table_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table_id' => 'ชุดข้อมูล',
            'code' => 'Code',
            'name' => 'ชื่อ',
            'status' => 'สถานะ',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'is_deleted' => 'Is Deleted',
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysTable()
    {
        return $this->hasOne(SysTable::className(), ['id' => 'table_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysModules()
    {
        return $this->hasMany(SysModule::className(), ['bd_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return SysBasicDataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SysBasicDataQuery(get_called_class());
    }

    /**
     * get data by table_id
     * @return Array
     */
    public static function getArrayGroup($table_id)
    {
        if ($table_id) {
            $models = SysBasicData::find()
                ->where(['table_id' => $table_id, 'status' =>SysBasicData::STATUS_ACTIVE])
                ->orderBy(['sorter' => SORT_ASC])
                ->all();
            return ArrayHelper::map($models, 'id', 'name');
        } else {

        }
        return [];

    }

}


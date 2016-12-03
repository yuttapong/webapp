<?php

namespace backend\modules\org\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "org_part".
 *
 * @property integer $id
 * @property integer $division_id
 * @property string $name
 * @property integer $created_at
 * @property integer $created_by
 *
 * @property OrgDepartment[] $orgDepartments
 * @property OrgDivision $division
 */


class OrgPart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_part';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['division_id', 'name', 'created_at', 'created_by'], 'required'],
            [['division_id', 'created_at', 'created_by'], 'integer'],
            [['name'], 'string', 'max' => 150],
            [['division_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrgDivision::className(), 'targetAttribute' => ['division_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'division_id' => 'ฝ่าย',
            'name' => 'ส่วนงาน',
            'division.name' => 'ฝ่าย',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
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
    public function getOrgDepartments()
    {
        return $this->hasMany(OrgDepartment::className(), ['part_id' => 'id']);
    }

    public  function getCountDepartment(){
        return count($this->orgDepartments);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrgDivision()
    {
        return $this->hasOne(OrgDivision::className(), ['id' => 'division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_code' => 'created_by']);
    }


    /**
     * @inheritdoc
     * @return OrgPartQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgPartQuery(get_called_class());
    }

    public function getDivisionList(){
        $model = OrgDivision::find()->orderBy('name')->all();
        return ArrayHelper::map($model,'id','name');
    }

    public function getPartList(){
        $model = OrgPart::find()->orderBy('name')->all();
        return ArrayHelper::map($model,'id','name');
    }
}

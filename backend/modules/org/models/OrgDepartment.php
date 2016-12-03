<?php

namespace backend\modules\org\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "org_department".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property integer $division_id
 * @property integer $part_id
 * @property string $email
 * @property integer $create_at
 * @property integer $create_by
 *
 * @property OrgDivision $division
 * @property OrgPart $part
 */
class OrgDepartment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_department';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'division_id', 'part_id', 'created_at', 'created_by'], 'integer'],
            [['id','code', 'name', 'part_id','division_id'], 'required'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 150],
            [['email'], 'string', 'max' => 60],
            [['division_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrgDivision::className(), 'targetAttribute' => ['division_id' => 'id']],
            [['part_id'], 'exist', 'skipOnError' => true, 'targetClass' => OrgPart::className(), 'targetAttribute' => ['part_id' => 'id']],
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
            'name' => 'แผนก',
            'division_id' => 'ฝ่าย',
            'part_id' => 'ส่วนงาน',
            'email' => 'Email',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'division.name' => 'ฝ่าย',
            'part.name' => 'ส่วนงาน',
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
    public function getOrgDivision()
    {
        return $this->hasOne(OrgDivision::className(), ['id' => 'division_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrgPart()
    {
        return $this->hasOne(OrgPart::className(), ['id' => 'part_id']);
    }




    /**
     * @inheritdoc
     * @return OrgDepartmentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgDepartmentQuery(get_called_class());
    }



    public function getDivisionList(){
        $model = OrgDivision::find()->orderBy('name')->all();
        return ArrayHelper::map($model,'id','name');
    }


    public function getPartList(){
        $model = OrgPart::find()->orderBy('name')->all();
        return ArrayHelper::map($model,'id','name');
    }


    public function getDepartmentList(){
        $model = OrgDepartment::find()->orderBy('name')->all();
        return ArrayHelper::map($model,'id','name');
    }

}

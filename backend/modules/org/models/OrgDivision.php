<?php

namespace backend\modules\org\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "org_division".
 *
 * @property integer $id
 * @property string $name
 * @property string $lastupdate
 * @property integer $crate_at
 * @property integer $create_by
 *
 * @property OrgDepartment[] $orgDepartments
 * @property OrgPart[] $orgParts
 */
class OrgDivision extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_division';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            [['id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ฝ่าย',
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
        return $this->hasMany(OrgDepartment::className(), ['division_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrgParts()
    {
        return $this->hasMany(OrgPart::className(), ['division_id' => 'id']);
    }

    /**
     *
     * @return int
     */
    public function getCountPart()
    {
        return count($this->orgParts);
    }

    /**
     * @return int
     */
    public function getCountDepartment()
    {
        return count($this->orgDepartments);
    }


    /**
     * @inheritdoc
     * @return OrgDivisionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgDivisionQuery(get_called_class());
    }


    public function getDivisionList()
    {
        $model = OrgDivision::find()->orderBy('name')->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

}

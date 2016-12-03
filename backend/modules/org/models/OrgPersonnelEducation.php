<?php

namespace backend\modules\org\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "org_personnel_education".
 *
 * @property integer $id
 * @property integer $personnel_id
 * @property string $education_name
 * @property string $branch
 * @property string $end_year
 * @property string $grade
 * @property integer $education_id
 * @property integer $degree_id
 * @property integer $degree_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgPersonnelEducation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel_education';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['education_name', 'branch'], 'required'],
            [['personnel_id', 'education_id', 'degree_id', 'degree_name', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['grade'], 'number'],
            [['education_name', 'branch'], 'string', 'max' => 100],
            [['end_year'], 'string', 'max' => 4],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'personnel_id' => 'Personnel ID',
            'education_name' => 'ชื่อสถาบัน',
            'branch' => 'สาขา',
            'end_year' => 'ปีที่จบ',
            'grade' => 'เกรด',
            'education_id' => 'organization table 22',
            'degree_id' => 'Degree ID',
            'degree_name' => 'arrary_data  table  key 23',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'sorter' => 'ลำดับ',
        ];
    }

    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className()

        ];
    }
    /**
     * @inheritdoc
     * @return OrgPersonnelEducationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgPersonnelEducationQuery(get_called_class());
    }
}

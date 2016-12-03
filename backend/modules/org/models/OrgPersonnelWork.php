<?php

namespace backend\modules\org\models;

use Yii;

/**
 * This is the model class for table "org_personnel_work".
 *
 * @property integer $id
 * @property integer $personnel_id
 * @property integer $year_work
 * @property string $company
 * @property string $business_type
 * @property string $address
 * @property string $foreman
 * @property string $phone
 * @property string $scope_work
 * @property string $out_cause
 * @property string $day_start_work
 * @property string $day_end_work
 * @property string $position_name
 * @property string $salary
 * @property string $other_income
 * @property integer $seq
 * @property integer $create_at
 * @property integer $create_id
 */
class OrgPersonnelWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_personnel_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['company','position_name'], 'required'],
            [['personnel_id', 'year_work', 'seq', 'created_at', 'created_by'], 'integer'],
            [['address', 'scope_work', 'reason_leaving'], 'string'],
            [['day_start_work', 'day_end_work'], 'safe'],
            [['salary', 'other_income'], 'number'],
            [['company', 'business_type', 'foreman', 'phone', 'position_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ประวัติการทำงาน',
            'personnel_id' => 'Personnel ID',
            'year_work' => 'ทำงานกีปี',
            'company' => 'บริษัท',
            'business_type' => ' ประเภทกิจการ',
            'address' => 'ที่อยู่',
            'foreman' => 'หัวหน้างาน',
            'phone' => 'Phone',
            'scope_work' => 'รายละเอียดงาน',
            'reason_leaving' => '  สาเหตุที่ออก',
            'day_start_work' => 'Day Start Work',
            'day_end_work' => 'Day End Work',
            'position_name' => 'ตำแหน่ง',
            'salary' => 'เงินเดือน',
            'other_income' => 'Other Income',
            'seq' => 'ลำดับ',
            'created_at' => 'Create At',
            'created_by' => 'Create ID',
        ];
    }

    /**
     * @inheritdoc
     * @return OrgPersonnelWorkQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgPersonnelWorkQuery(get_called_class());
    }
}

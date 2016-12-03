<?php

namespace backend\modules\org\models;


use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "org_position".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property double $level
 * @property string $name_th
 * @property string $name_en
 * @property string $type
 * @property double $salary
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class OrgPosition extends \yii\db\ActiveRecord
{
	

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name_th', 'name_en','part_id','department_id','division_id'], 'required'],
            [['id', 'parent_id', 'created_at',
                'created_by', 'updated_at', 'updated_by',
                'division_id', 'part_id', 'department_id'
            ], 'integer'],
            [['level', 'salary','active'], 'number'],
            [['name_th', 'name_en'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'parent_id' => 'หัวหน้างาน',
            'level' => 'ระดับตำแหน่ง',
            'name_th' => 'ชื่อตำแหน่ง',
            'name_en' => 'ชื่อตำแหน่ง(อังกฤษ)',
            'salary' => 'เงืนเดือน',
            'created_at' => 'สร้างเมื่อ',
            'created_by' => 'สร้างโดย',
            'updated_at' => 'แก้ไขเมื่อ',
            'updated_by' => 'แก้ไขโดย',
            'parent.name_th' => 'หัวหน้างาน',
            'division_id' => 'ฝ่าย',
            'part_id' => 'ส่วนงาน',
            'department_id' => 'แผนก',
        	'levelName'=>'ระดับ'

        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     * @return OrgPositionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgPositionQuery(get_called_class());
    }


    public function getItems($key)
    {
        $datas = [
            'level' => [
                '1' => 'ผู้บริหาระดับสูง',
                '2' => 'ผู้บริหารระดับกลาง',
                '3' => 'ผู้บริหารระดับต้น',
                '4' => 'บุคคลากรระดับปฏิบัติการ',
            ]
        ];
        return ArrayHelper::getValue($datas, $key, []);
    }

    public function getLevelItems()
    {
        return $this->getItems('level');
    }

    public function getLevelName()
    {
        return ArrayHelper::getValue($this->levelItems,$this->level);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(OrgPosition::className(), ['id' => 'parent_id']);
    }

    /**
     * @return array
     */
    public function getArrayPositionParent()
    {
        if ($this->isNewRecord) {
            $model = OrgPosition::find()
                ->orderBy('name_th')
                ->all();
        } else {
            $model = OrgPosition::find()
                ->where(['not in', 'id', [$this->id]])
                ->orderBy('name_th')
                ->all();
        }
        if ($model)
            return ArrayHelper::map($model, 'id', 'name_th');
    }


    public function getOrgDivision()
    {
        return $this->hasOne(OrgDivision::className(), ['id' => 'division_id']);
    }


    public function getOrgPart()
    {
        return $this->hasOne(OrgPart::className(), ['id' => 'part_id']);
    }

    public function getOrgDepartment()
    {
        return $this->hasOne(OrgDepartment::className(), ['id' => 'department_id']);
    }

    public function getProperties() {
    return $this->hasMany(OrgPositionProperty::className(), ['position_id' => 'id'])
        	->select('org_job_option.title, org_position_property.*')
           	->innerJoin(OrgJobOption::tableName(), 'org_job_option.id = org_position_property.option_id')
            ->where(['_type'=> OrgJobOption::TYPE_PROPERTY])->orderBy('sorter');
    	
  
    }
    public function getResponsibilities()
    {
        return $this->hasMany(OrgPositionProperty::className(), ['position_id' => 'id'])
        		->select('org_job_option.title, org_position_property.*')
        		->innerJoin(OrgJobOption::tableName(), 'org_job_option.id = org_position_property.option_id')
            	->where(['_type'=> OrgJobOption::TYPE_RESPONSIBILITY])->orderBy('sorter');
    }
    
 

}

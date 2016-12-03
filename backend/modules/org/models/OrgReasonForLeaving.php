<?php

namespace backend\modules\org\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "org_reason_for_leaving".
 *
 * @property integer $id
 * @property integer $personnel_id
 * @property string $end_day_work
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 */
class OrgReasonForLeaving extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'org_reason_for_leaving';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['personnel_id', 'leaving_date'], 'required'],
            [['personnel_id', 'created_at', 'created_by'], 'integer'],
            [['leaving_date'], 'safe'],
            [['note'], 'string'],
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
            'leaving_date' => 'วันที่ลาออก',
            'note' => 'หมายเหตุการลาออก',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     * @return OrgReasonForLeavingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrgReasonForLeavingQuery(get_called_class());
    }

    /**
     * @param $key
     * @return array
     */
    public function getItems($key)
    {
        $items = [
            'reasonForLeaving' => [
                1 => 'ไม่มีความก้าวหน้าในอาชีพ',
                2 => 'บริษัทเลืกกิจการ',
                3 => 'ตำแหน่งไม่เหมาะสม',
                4 => 'สิ้นสุดสัญญา',
                5 => 'เพื่อการศึกษาต่อ',
                6 => 'เพื่อเข้าเป็นทหาร',
                7 => 'ต้องการงานที่ดีกว่า',
                8 => 'บริษัทขาดทุน',
                9 => 'บริษัทลดพนักงาน',
                10 => 'เป็นงานชั่วคราว',
            ]
        ];
        return ArrayHelper::map($items, $key);
    }

    
    /**
     * @return array
     */
    public function getReasonItems()
    {
        return self::getItems('reasonForLeaving');
    }


    /**
     * @return mixed
     */
    public function getReasonName()
    {
        return @self::getItems('reasonForLeaving')[$this->reason_key];
    }
}

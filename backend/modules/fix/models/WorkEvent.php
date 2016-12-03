<?php

namespace backend\modules\fix\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fix_work_event".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $create_at
 * @property integer $create_by
 */
class WorkEvent extends \yii\db\ActiveRecord
{
    const  STATUS_ACTIVE = 1;
    const  STATUS_INACTIVE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_work_event';
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert)) {
    		
    		$this->start_date = strtotime($this->start_date);
    		if($this->end_date!=''){
    		$this->end_date = strtotime($this->end_date);
    		}
    		if ($this->isNewRecord) {
    			$this->created_at=time();
    			$this->created_by=Yii::$app->user->id;
    		}else{
    
    		}
    		return true;
    	} else {
    		 
    		return false;
    	}
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'start_date'], 'required'],
            [['created_at','is_delete', 'created_by'], 'integer'],
        	[['end_date'], 'safe'],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'รายการ',
            'description' => 'ลายระเอียด',
            'start_date' => 'วันเริ่ม',
            'end_date' => 'วันสิ้นสุด',
            'created_at' => 'Create At',
            'created_by' => 'Create By',
        		'is_delete'=> 'ลบข้อมูล',
        ];
    }



    public function getStatisItems(){
        return [
            self::STATUS_ACTIVE => 'ใช้งาน',
            self::STATUS_INACTIVE => 'ยกเลิก',

        ];
    }


    public function getStatusName(){
        return ArrayHelper::getValue(self::getStatisItems(),$this->status);
    }
}

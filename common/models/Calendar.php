<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sys_calendar".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_delete
 * @property integer $status
 */
class Calendar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	public $date_range;
	
	const  TYPE_OTHER = 'other'; //อื่น ๆ
	const  TYPE_FIX_APPOINTMENTS = 'tb_fix_appointments'; // ต่ารงแจ้งซ่อม 
	
    public static function tableName()
    {
        return 'sys_calendar';
    }
    public static function getTypeItems()
    {
    	return [
    			
    			self::TYPE_FIX_APPOINTMENTS => 'ตารางนัดแจ้งซ่อม',
    			self::TYPE_OTHER => 'อื่น ๆ',

    	];
    }
    public function getTypeName(){
    	return ArrayHelper::getValue(self::getTypeItems(), $this->slug);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'description', 'start_date'], 'required'],
            [['created_at', 'created_by', 'is_delete', 'status','table_key'], 'integer'],
        	[['description'], 'string'],
        	[['slug'], 'string', 'max' => 200],
        	[['title'], 'string', 'max' => 50],
            [['table_name'], 'string', 'max' => 500],
        	[['start_date','end_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'start_date' => 'วันเริ่ม',
            'end_date' => 'วันสิ้นสุด',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_delete' => 'Is Delete',
            'status' => 'Status',
        	'table_name'=>'table_name',
        	'table_key'=>'table_key',
        	'user_responsible'=>'ผู้รับผิดชอบ',
        	'slug'=>'slug'
        ];
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
}

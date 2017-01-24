<?php

namespace backend\modules\purchase\models;

use Yii;
use common\models\SysDocumentPosition;
use common\models\SysDocumentPersonnel;
use common\models\ConfirmApprever;
use backend\modules\org\models\Personnel;
use common\models\Project;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "fix_prin".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property string $description
 * @property integer $type
 * @property integer $user_order_id
 * @property integer created_at
 * @property integer created_by
 * @property integer $site_id
 * @property integer $project_id
 */
class Pr extends \yii\db\ActiveRecord
{
	const  CODE_TABLE_NAME = 'psm_pr'; // table_id จากตาราง sys_table
	/*
	 * สถานะการทำงาน
	 */
	const  STATUS_WAIT = 1;
	const  STATUS_PROCEED = 2;
	const  STATUS_COMPLETE = 3;
	
    /**
     * @inheritdoc
     */
	
	
    public static function tableName()
    {
        return 'psm_prin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['type', 'user_order_id', 'created_at', 'created_by', 'site_id', 'project_id','apprever_seq','work_status','is_cancel','is_approve'], 'integer'],
            [['code','module_slug'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 255],
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
            'title' => 'Title',
            'description' => 'Description',
        		'work_status' => 'สถานะการทำงาน',
            'type' => 'ประเภทการซื้อ',
            'user_order_id' => 'ผู้สังซื้อ',
            'created_at' => 'Create At',
            'created_by' => 'Create By',
            'site_id' => 'Site ID',
            'project_id' => 'Project ID',
        		'is_approve' => 'is_approve ID',
        		'is_cancel' => 'is_cancel ID',
        	'apprever_seq'=>'apprever_seq',
        		'workStatusName'=>'สถานะ'
        ];
    }
    public   static function getWorkStatus(){
    	return [
    			self::STATUS_WAIT => 'รอดำเนินการ',
    			self::STATUS_PROCEED => 'กำลังดำเนินการ',
    			self::STATUS_COMPLETE => 'เสร็จ'
    	];
    }
    public function getWorkStatusName(){
    	return ArrayHelper::getValue(self::getWorkStatus(), $this->work_status);
    }
    public function getPrinMaterials()
    {
    	return $this->hasMany(PrDetail::className(), ['prin_id' => 'id']);
    }
    public function getPersonnel()
    {
    	return $this->hasOne(Personnel::className(), ['user_id' => 'created_by']);
    }
    public function getUsePersonnel($user_id)
    {
    	$st_data=  Personnel::findOne(['user_id'=>$user_id]) ;
    	return $st_data;
    }
    public function getProject()
    {
    	return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
    public function getPersonnels(){
    	$data=[];
    	foreach (Personnel::find()->where(['active'=>1])->all() as $val ){
    		$data[$val->id]=$val->prefix_name_th.' '.$val->firstname_th.' '.$val->lastname_th;
    	}
    	return $data;
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert)) {
    
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

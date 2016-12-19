<?php

namespace backend\modules\fix\models;

use Yii;
use common\models\Project;
use common\models\Home;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "fix_inform_fix".
 *
 * @property integer $id
 * @property integer $project
 * @property integer $home_id
 * @property integer $seq
 * @property string $title
 * @property string $description
 * @property integer $date_inform
 * @property integer customer_id
 * @property string customer_name
 * @property integer $job_status
 * @property integer $job_sub_status
 * @property integer $work_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $type
 */
class InformFix extends \yii\db\ActiveRecord
{
	
	const UPLOAD_PATH  = 'upload/fix/inform';
	const RESUME_PATH  = 'resumes';
    /**
     * @inheritdoc 
customer
     */
	const  CODE_TABLE_NAME = 'fix_inform_fix'; // table_id จากตาราง sys_table
	const  CODE_STRING = 'HF'; //ตัวษรสำหรับใช้ในออกรูปแบบโค้ด
	/*
	 * ประเภทผู้กรอกข้อมูล
	 */
	const  TYPE_CUSTOMR = 1;
	const  TYPE_INFORM = 2;
	const  TYPE_STAFF = 3;
	/*
	 * สถานะการทำงาน
	 */
	const  STATUS_WAIT = 1;
	const  STATUS_PROCEED = 2;
	const  STATUS_COMPLETE = 3;
	
    public static function tableName()
    {
        return 'fix_inform_fix';
    }
    public function beforeSave($insert){
    	if (parent::beforeSave($insert)) {
    			
    		if ($this->isNewRecord) {
    			if($this->date_inform!='' && $this->date_inform!='0'){
    				$this->date_inform = strtotime($this->date_inform);
    			}
    			if($this->date_modify!='' && $this->date_modify!='0'){
    				$this->date_modify = strtotime($this->date_modify);
    			}
    			$this->created_at=time();
    			$this->created_by=Yii::$app->user->id;
    		}else{
    			 
    		}
    		return true;
    	} else {
    		 
    		return false;
    	}
    }
 
 	public function afterFind()  {
        parent::afterFind();
       // $this->date_inform = date("Y-m-d H:i", $this->date_inform);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
        	[['project_id','prefixname', 'home_id', 'customer_name','date_inform'], 'required'],
            [['id', 'project_id','is_send','is_delete', 'home_id', 'seq', 'customer_id', 'job_status', 'job_sub_status', 'work_status', 'created_at', 'created_by','is_calendar', 'type'], 'integer'],
            [['description','option'], 'string'],
            [[ 'customer_name','telephone'], 'string', 'max' => 255],
        	[['code'], 'string', 'max' => 20],
        	[['date_modify'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'โครงการ',
            'home_id' => 'แปลงบ้าน',
            'seq' => 'Seq',
        	'code' => 'เลขที่เอกสาร',
            'telephone' => 'เบอร์โทรศัพท์',
            'description' => 'ลายละเอียด',
            'date_inform' => 'วันที่แจ้ง',
            'customer_id' => 'Customs ID',
        	'prefixname' => 'คำนำหน้า',
            'customer_name' => 'ชื้อ-สกุล ผู้แจ้ง',
            'job_status' => 'สถานะการทำงาน',
            'job_sub_status' => 'Job Sub Status',
            'work_status' => 'สถานะการทำงาน',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'type' => 'Type',
        	'is_send'=> 'ส่ง',
        	'is_delete'=> 'ลบข้อมูล',
        	'date_modify'=>'วันที่แก้ไข',
        	'is_calendar'=>'is_calendar',
        	'option' => 'Option',
        ];
    }

    public static function getTypeItems()
    {
    	return [
    			self::TYPE_CUSTOMR => 'ลู้ค่าแจ้งและกรอกข้อมูลเอง',
    			self::TYPE_INFORM => 'ลูกค้าแจ้งพนักงานให้แจ้งให้',
    			self::TYPE_STAFF => 'พนักงานแจ้งเอง'
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
    public function getProject()
    {
    	return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
    public function getHome()
    {
    	return $this->hasOne(Home::className(), ['id' => 'home_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInformJobs()
    {
    	return $this->hasMany(InformJob::className(), ['inform_fix_id' => 'id']);
    }
    public function getInformMaterial()
    {
    	return $this->hasMany(InformMaterial::className(), ['inform_fix_id' => 'id']);
    }
    public function getSendDocumentsl()
    {
    	return $this->hasMany(SendDocuments::className(), ['table_key' => 'id'])
    	->andWhere(['table_name' => 'fix_inform_fix']);
    }
 
    public function getListApprever()
    {
    	return $this->hasMany(ListApprever::className(), ['inform_fix_id' => 'id']);
    }
    public function getUploads()
    {
    	return $this->hasMany(Uploads::className(), ['ref' => 'id'])
    	->andWhere(['table_name' => 'fix_inform_fix']);
    }
    public static function getUploadPath(){
    	return Yii::getAlias('@webroot').'/'.self::UPLOAD_PATH;
    }
    public static function getUploadUrl(){
    	return Url::base(true).'/'.self::UPLOAD_PATH;
    }
    
    public static function getResumePath(){
    	return Yii::getAlias('@webroot').'/'.self::RESUME_PATH;
    }
    
    public static function getResumeUrl(){
    	return Url::base(true).'/'.self::RESUME_PATH;
    }
    public function getThumbnails($ref,$event_name){
    	$uploadFiles   = Uploads::find()->where(['ref'=>$ref,'table_name' => 'fix_inform_fix'])->all();
    	$preview =$files= [];
    	foreach ($uploadFiles as $file) {
    		if($file->type==1){
	    		$preview[] = [
	    				'url'=>self::getUploadUrl(true).'/'.$ref.'/'.$file->real_filename,
	    				'src'=>self::getUploadUrl(true).'/'.$ref.'/thumbnail/'.$file->real_filename,
	    				'options' => ['title' => $event_name]
	    		];
	    	}else{
	    		$files[]=[
	    				'path'=>$file->real_filename,//self::getUploadPath().'/'.$ref.'/'.$file->real_filename,
	    				'name'=>$file->file_name,
	    				'href'=>self::getUploadUrl(true).'/'.$ref.'/'.$file->real_filename,
	    				'upload_id'=>$file->upload_id,
	    		];
	    	}
    	}
    	$arr['img']=$preview;
    	$arr['other']=$files;
    	
    	return $arr;
    }
    
}

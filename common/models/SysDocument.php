<?php

namespace common\models;

use backend\modules\org\models\OrgSite;
use Yii;
use backend\modules\org\models\OrgPersonnel;

/**
 * This is the model class for table "sys_document".
 *
 * @property integer $document__id
 * @property string $name
 * @property string $description
 * @property integer $document_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class SysDocument extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_document';
    }
    /**
    * นับข้อความที่ยังไม่ได้อ่านเพื่อแจ้งเตือนที่ navbar ด้านบน
    * @return array
    */
    
    public static function countNewDocument()
    {
    
    	$userId = Yii::$app->user->id;
    
    	$query = new \yii\db\Query;
    
    	$query->select('
    
        d.name as document,
    
        m.document_id, count(m.document_id) as countNew,
    
        d.url_message
    
        ')
    
            ->from('sys_list_message m')
    
            ->leftJoin('sys_document d', 'd.document_id = m.document_id')
    
            ->where("m.app_status='0' AND user_approver_id='$userId' ");
    
    	$command = $query->createCommand();
    
    	$model = $command->queryAll();
    
    	return $model;
    
    }
    /**
    
    * นับความแจ้งเตือนใหม่ทั้งหมด
    
    * @return int
    
    */
    
    public static function CountTotalNewDocument()
    
    {
    
    	$newMessages = SysDocument::countNewDocument();
    
    	$totalNewMessage = 0;
    
    	foreach ($newMessages as $message) {
    
    		$totalNewMessage += $message['countNew'];
    
    	}
    
    	return $totalNewMessage;
    
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['document_status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
 public function attributeLabels()
    {
        return [
            'document_id' => Yii::t('system', 'Document  ID'),
            'name' => Yii::t('system', 'Name'),
            'description' => Yii::t('system', 'Description'),
            'document_status' => Yii::t('system', 'Document Status'),
            'created_at' => Yii::t('system', 'Created At'),
            'created_by' => Yii::t('system', 'Created By'),
            'updated_at' => Yii::t('system', 'Updated At'),
            'updated_by' => Yii::t('system', 'Updated By'),
        ];

    }

    public function getDocumentOptions()
    {
        return $this->hasMany(SysDocumentOption::className(), ['document_id' => 'document_id'])->orderBy('seq');
    }
    
    public function getDocumentPersonnel()
    {
    	return $this->hasMany(SysDocumentPersonnel::className(), ['document_id' => 'document_id']);
    }
    public function getSite()
    {
        return $this->hasOne(OrgSite::className(), ['site_id' => 'document_id']);
    }
    public function getDocumentPosition()
    {
    	return $this->hasMany(SysDocumentPosition::className(), ['document_id' => 'document_id'])->orderBy('seq');
    }
    public static function getDataApprove($document_id,$option=[]){
    	
    	$model=SysDocument::findOne($document_id);
    	$dataDoc=$model->documentOptions;
    $approvers = []; // เก็บข้อมูลรายชื่อผู้ที่จะอนุมัติ
    	foreach ($dataDoc as $index => $val) {
    		if($val->active=='1'){
	    		if($val->_type==SysDocumentOption::TYPE_ORGANIZATION){
	    		 $approvers[]=	SysDocument::getDataOrganization($option['user_id']);
	    		}elseif($val->_type==SysDocumentOption::TYPE_CUSTOM){
	    			$approvers[]=	SysDocument::getDataCustom($document_id,$option);
	    		}elseif($val->_type==SysDocumentOption::TYPE_POSITION){
	    			$approvers[]=	SysDocument::getDataPosition($document_id);
	    		}
    		}
    		
    	}
    	$users = [];
        $i = 1;
        foreach ($approvers as $list) {
            foreach ($list as $key => $val) {
            	if(!empty($users[$val['user_id']])){
            		unset($users[$val['user_id']]);
            	}
            	
                $users[$key] = $val;
                $i++;
            }
        }
        if(!empty($users[$option['user_id']])){
        	unset($users[$option['user_id']]);
        }
        return $users;
    }
    
    
    public function getDataOrganization($user_id){
    	$approver_user_id = $user_id;
    	$company_id = 3;
    	
    	$arr_doc = array();
    	if ($user_id != '') {
    		/*
    		 * ค้นหาว่าอยู๋ site ไหน
    		 */
    		$sqlGet = " SELECT zz.*,op.name_th,op.`level`
               FROM (
					SELECT osi.id, osu.site_id,osi.position_id,osi.user_code,osi.company_id,osi.user_id
            		FROM org_structure_item osi
					INNER JOIN org_site_user osu on osi.user_id=osu.user_id
					WHERE   osi.user_id=:user_id
					GROUP BY osi.position_id
				) zz
				INNER JOIN org_position op on op.id=zz.position_id
				ORDER BY op.`level`*1   ";
    		/*
    		 * AND osu.site_id=:site_id
    		 AND company_id=:company_id
    		 */
    		$rows = Yii::$app->db->createCommand($sqlGet, [
    				'user_id' => $approver_user_id,
    				#'company_id' => $option['company_id'],
    				#'site_id' => $option['site_id']
    		])->queryOne();
    		$structure_item_id= $rows['id'];// org_structure_item id
    		
    		 $sqlGetuser = "SELECT   T2.user_id, T2.user_code ,p.name_th,p.`level` ,T2.position_id,T1.parent_id
    		FROM (
    		SELECT @r AS m_id,h.position_id,h.company_id,
    		(SELECT @r :=parent_id FROM org_structure_item WHERE id = m_id) AS parent_id,
    		@l := @l + 1 AS lvl
    		FROM
    		(SELECT @r := '$structure_item_id', @l := 0) vars,
    		org_structure_item h
    		WHERE @r <> 0 AND h.company_id='$company_id'
    		)  T1
    		JOIN org_structure_item T2 ON T1.m_id = T2.id
    		INNER JOIN org_position p on p.id=T2.position_id
    		ORDER BY T1.lvl asc ,`level` desc ";
    		$sqlquery = Yii::$app->db->createCommand($sqlGetuser)->query();
    		$level=1;
    		//if(isset($option['docData']['level'])){
    		//	$level = $option['docData']['level']; // ระดับทีกำหนดไว้ในระบบ
    		//}
    		foreach ($sqlquery as $row) {
    
    			if ($row['user_id'] != '' && $row['parent_id']!='0') {
    				//ถ้าผู้อนุมัติ มีระดับมากกว่าหรือเท่ากับที่กำหนดไว้ในระบบ และมีค่าระดับไม่เป็นค่าว่าง
    				if ($row['level'] >= $level && $level != '') {
    					$person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
    					$arr_doc[$row['user_id']]['user_id'] = $person->user_id;
    					$arr_doc[$row['user_id']]['user_code'] = $person->code;
    					$arr_doc[$row['user_id']]['user_name'] = $person->fullnameTH;
    					if($row['parent_id']!='0'){
    						if(empty($arr_doc[$row['user_id']]['position_name'])){
    						$arr_doc[$row['user_id']]['position_name']= $row['name_th'];
    						}
    					}
    					$arr_doc[$row['user_id']]['active'] = 0;
    					$arr_doc[$row['user_id']]['position_level'] = $row['level'];
    				}
    				//ถ้าระดับของผู้อนุมัติมีค่าว่าง
    				if ($level == '') {
    					$person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
    					$arr_doc[$row['user_id']]['user_id'] = $person->user_id;
    					$arr_doc[$row['user_id']]['user_code'] = $person->code;
    					$arr_doc[$row['user_id']]['user_name'] = $person->fullnameTH;
    					
    					
    					$arr_doc[$row['user_id']]['position'][$row['position_id']] = $row['name_th'];
    					$arr_doc[$row['user_id']]['active'] = 0;
    					$arr_doc[$row['user_id']]['position_level'] = $row['level'];
    
    				}
    			}
    		}
    	}
    
    	
    	return $arr_doc;
    }
    
    public function getDataPosition($document_id,$option=[])  {
    	$DocumentOption=SysDocumentOption::findOne(['document_id'=>$document_id,'_type'=>'Position']);
    
    	$data=unserialize( $DocumentOption->data);
    	
    	$datax=[];
    	foreach ($data as $val){
    		$datax[$val['position_id']]=$val['position_id'];
    	
    	}
    	
    	$position='\''.implode("','",$datax).'\'';
    	$con='';
    	if($position!=''){
    	 	 $con=" AND osi.position_id in( $position ) ";
    	}
    	$arr_doc = array();
    	  $sqlPosition = "SELECT osi.id,osi.user_id,osi.user_code,osi.parent_id,
    	osi.first_name,osi.position_id ,osu.site_id,op.name_th,op.`level`
    	FROM org_structure_item osi
    	INNER JOIN org_site_user osu on osi.user_id=osu.user_id
    	INNER JOIN org_position op on op.id=osi.position_id
    	WHERE  1=1 $con
    	GROUP BY  osi.position_id 
    	ORDER BY op.`level` desc "; //AND osi.position_id in('$position')
    	$sqlPos = Yii::$app->db->createCommand($sqlPosition)->query(); //osu.site_id='3'
    
    	// if ($seq == 1) {
    	// $arr_doc[$option['user_id']] = $option['user_id'];//ดึงข้อมูลมาจาก$_SESSION['user_code']
    	// }
    	foreach ($sqlPos as $row) {
    		$person = OrgPersonnel::findOne(['user_id' => $row['user_id']]);
    		$arr_doc[$row['user_id']]['user_id'] = $person->user_id;
    		$arr_doc[$row['user_id']]['user_code'] = $person->code;
    		$arr_doc[$row['user_id']]['fullname'] = $person->fullnameTH;
    		$arr_doc[$row['user_id']]['position'][$row['position_id']] = $row['name_th'];
    		$arr_doc[$row['user_id']]['active'] = 0;
    		$arr_doc[$row['user_id']]['position_level'] = $row['level'];
    	}
    	return $arr_doc;
    }
    
 
    
    public function getDataCustom($document_id,$option=[])  {
     	$site_id=!empty($option['site_id'])?$option['site_id']:'';
    	//$option['site_id']
    	$arr=[]; 
    	$dataPersonnel=SysDocument::getAppPersonnel($document_id);
    	
    	
    	/**
    	 * ตำแหน่งที่อนุมัติว่่ามีกี่ตำแหน่ง
    	*/
    	$st_data=  SysDocumentPosition::find()
    	->where(['document_id'=>$document_id])
    	->all();
    	foreach($st_data as $row)  {
    		$arr[$row->seq]['id']=$row->id;
    		$arr[$row->seq]['position_name']=$row->position_name;
    		$arr[$row->seq]['user_id']='';
    		$arr[$row->seq]['user_name']='';
    		$arr[$row->seq]['active']=0;
    		$arr[$row->seq]['user_code']=0;
    		
    		/*
    		 * site นี้มีผู้อนุมัติหรือไม่
    		 */
    		if(!empty($dataPersonnel[$row->id][$site_id])){
    			$dataPerson=SysDocument::getUsePersonnel($dataPersonnel[$row->id][$site_id]['user_id']);
    		
    			$arr[$row->seq]['user_id']=$dataPersonnel[$row->id][$site_id]['user_id'];
    			$arr[$row->seq]['user_name']=$dataPerson->prefix_name_th.' '.$dataPerson->firstname_th.' '.$dataPerson->lastname_th;
    			//if($this->created_by==$dataPersonnel[$row->id][$this->site_id]['user_id']){
    			//unset($arr[$row->seq]);
    			//}
    		}elseif(!empty($dataPersonnel[$row->id][''])){
    			$dataPerson=SysDocument::getUsePersonnel($dataPersonnel[$row->id]['']['user_id']);
    			$arr[$row->seq]['user_id']=$dataPersonnel[$row->id]['']['user_id'];
    			$arr[$row->seq]['user_code']=$dataPersonnel[$row->id]['']['user_id'];
    			$arr[$row->seq]['user_name']='ddd';
    			$arr[$row->seq]['user_name']=$dataPerson->prefix_name_th.' '.$dataPerson->firstname_th.' '.$dataPerson->lastname_th;
    		}
    		if(!empty($dataConA[$row->id]['document_position_id'])){
    			$arr[$row->seq]['active']=1;
    			$arr[$row->seq]['user_id']=$dataConA[$row->id]['user_id'];
    			$arr[$row->seq]['user_name']=$dataConA[$row->id]['user_name'];
    		}
    	}
    
    	return $arr;
    }
    /*
     * ข้อมูลผู้อนุมัติทั้งหมด
     */
    public function getAppPersonnel($document_id){
    	$arr=[];
    	$st_data=  SysDocumentPersonnel::find()->where(['document_id' =>$document_id])->all();
    	foreach($st_data as $row)  {
    		$arr[$row->document_position_id][$row->site_id]['id']=$row->id;
    		$arr[$row->document_position_id][$row->site_id]['user_id']=$row->user_id;
    		$arr[$row->document_position_id][$row->site_id]['type']=$row->type;
    	}
    	return $arr;
    }
    public function getUsePersonnel($user_id)
    {
    	$st_data=  OrgPersonnel::findOne(['user_id'=>$user_id]) ;
    	return $st_data;
    }

}

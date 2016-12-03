<?php

namespace backend\modules\fix\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "fix_list_apprever".
 *
 * @property integer $id
 * @property integer table_key
 * @property integer $approver_user_id
 * @property integer $approver_seq
 * @property integer $user_next_id
 * @property string $description
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $approval_status
 * @property string $table_name
 */
class ListApprever extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fix_list_apprever';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_selected','list','is_pr'], 'required'],
            [['id', 'inform_fix_id','is_pr', 'approver_user_id', 'approver_seq', 'user_next_id', 'created_at', 'created_by', 'approval_status'], 'integer'],
            [['description','list','job_selected'], 'string'],
           # [['table_name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        	'list'=> 'รายการ',
            'inform_fix_id' => 'inform_fix_id ID',
            'approver_user_id' => 'Approver User ID',
            'approver_seq' => 'Approver Seq',
            'user_next_id' => 'User Next ID',
            'job_selected' => 'เลือก',
        	'description' => 'หมายเหตุ',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'approval_status' => 'Approval Status',
        		'is_pr'=> 'Approval Status',
        ];
    }
    public function getSelectedJob()
    {
    	//return  array(17);
    	$data=array(17);
    	return Json::encode($data);
    	 
    }
    public function getInformMaterial()
    {
    	return $this->hasMany(InformMaterial::className(), ['inform_fix_id' => 'inform_fix_id']);
    }
}

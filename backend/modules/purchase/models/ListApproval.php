<?php

namespace backend\modules\purchase\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "psm_list_approval".
 *
 * @property integer $id
 * @property string $subject
 * @property integer $job_list_id
 * @property string $description
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 * @property integer $status
 * @property integer $approve_user_id
 * @property integer $approve_seq
 * @property integer $user_next_id
 * @property integer $approve_status
 */
class ListApproval extends \yii\db\ActiveRecord
{

    // status approve
    const STATUS_DRAFT = 'draft';
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';




    // active or inactive
    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;



    public  $listapprover;
    public  $requestBy;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_list_approval';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['job_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active', 'approve_user_id', 'approve_seq', 'user_next_id', 'approve_status'], 'integer'],
            [['description','requestBy'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['subject', 'description', 'job_list_id'], 'required'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'เรื่อง',
            'job_list_id' => 'หมวดงาน',
            'description' => 'รายละเอียด',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'active' => 'Active',
            'approve_user_id' => 'ผู้ขออนุมัติ',
            'approve_user_name' => 'ผู้ขออนุมัติ',
            'approve_seq' => 'ลำดับที่อนุมัติ',
            'user_next_id' => 'ผู้อนุมัติต่อไป',
            'approve_status' => 'สถานะอนุมัติ',
        ];
    }

    public function getAllApproveConfirms(){
         return $this->hasMany(ApproverComfirm::className(),['pk_key'=> 'id']);
    }


    public function getActiveApproveConfirms(){
        return $this->hasMany(ApproverComfirm::className(),['pk_key'=>'id']);
    }

    public function getUserCreated(){
        return $this->hasOne(Personnel::className(),['user_id'=>'created_by']);
    }




    /**
     * หารายชื่อผู้ที่มีสิทธิ์อนุมัติเอกสารทึ้งหมด
     * @return array
     */
    public function getActiveApproveConfirmItems(){
        $models = ApproverComfirm::find()
           ->where([
               'active' => ApproverComfirm::ACTIVE_YES,
               'pk_key' => $this->id
           ])
           ->all();
        $data = [];
        foreach ($models as $model) {
            $data[] = [
                'id' => $model->id,
                'user_id' => $model->approve_user_id,
                'name' =>  $model->approveFullname,
                'position' => 'Position',
                'seq' => $model->seq,
                'approve_date' => $model->approve_date,
                'approve_status' => $model->approve_status,
                'active' => $model->active,
            ];
        }
        return $data;
    }

    /**
     * หา id  รายการที่ผู้ใช้งานอนุมัติแล้ว
     * @return array
     */
    public function getListUserHasApproved(){
        $models = ApproverComfirm::find()
            ->where([
                'active' => ApproverComfirm::ACTIVE_YES,
                'pk_key' => $this->id
            ])
            ->all();
        $data  = ArrayHelper::map($models,'id', 'id');
        return $data;
    }


}

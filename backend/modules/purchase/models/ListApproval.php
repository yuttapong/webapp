<?php

namespace backend\modules\purchase\models;

use Yii;

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
 * @property integer $approver_user_id
 * @property integer $approver_seq
 * @property integer $user_next_id
 * @property integer $approval_status
 */
class ListApproval extends \yii\db\ActiveRecord
{

    const   STATUS_PENDING = 1;
    const   STATUS_PROCESSING = 2;
    const   STATUS_SUCCESS = 3;
    const   STATUS_CANCEL = -1;


    public $approver_user_name;

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
            [['job_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'status', 'approver_user_id', 'approver_seq', 'user_next_id', 'approval_status'], 'integer'],
            [['description'], 'string'],
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
            'approver_user_id' => 'ผู้ขออนุมัติ',
            'approver_user_name' => 'ผู้ขออนุมัติ',
            'approver_seq' => 'ลำดับที่อนุมัติ',
            'user_next_id' => 'ผู้อนุมัติต่อไป',
            'approval_status' => 'สถานะอนุมัติ',
        ];
    }
}

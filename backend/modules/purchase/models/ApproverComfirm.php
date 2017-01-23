<?php

namespace backend\modules\purchase\models;

use Yii;

/**
 * This is the model class for table "psm_approver_comfirm".
 *
 * @property integer $id
 * @property string $slug
 * @property integer $pk_key
 * @property integer $fk_key
 * @property integer $approver_user_id
 * @property integer $seq
 * @property string $comment
 * @property integer $approver_status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $active
 */
class ApproverComfirm extends \yii\db\ActiveRecord
{

    // status approve
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const  STATUS_PENDING  = 'pending';



    // active or inactive
    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;

    const DOCUMENT_GENERAL_PR = 'general_pr';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'psm_approver_comfirm';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pk_key', 'fk_key', 'approve_user_id', 'seq', 'created_at', 'created_by', 'active'], 'integer'],
            [['comment','position_name'], 'string'],
            [['approve_status'],'string','max' => 20],
            [['slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'pk_key' => 'Pk Key',
            'fk_key' => 'Fk Key',
            'approve_user_id' => 'Approver User ID',
            'seq' => 'Seq',
            'comment' => 'Comment',
            'approve_status' => 'Approve Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'active' => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApproveFullname() {
         return  Personnel::findOne(['user_id' => $this->approve_user_id])->getFullnameTH();
    }
}

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
    const STATUS_PROCESSING = 'processing';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CANCELED = 'canceled';
    const  STATUS_COMPLETE = 'complete';

    // active or inactive
    const ACTIVE_YES = 1;
    const ACTIVE_NO = 0;

    public $listapprover;
    public $requestBy;

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
            [['job_list_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'active', 'approve_user_id', 'approve_seq'], 'integer'],
            [['description', 'requestBy','approve_name'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['approve_status'], 'string', 'max' => 20],
            [['subject', 'description', 'job_list_id','approve_status'], 'required'],

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
            'created_by' => 'ผู้ขอ',
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

    public static function getStatusItem()
    {
        return [
            self::STATUS_DRAFT => 'ร่าง',
            self::STATUS_PENDING => 'รออนุมัติ',
            self::STATUS_PROCESSING => 'กำลังดำเนินการ',
            self::STATUS_REJECTED => 'ไม่อนุมัติ',
            self::STATUS_APPROVED => 'อนุมัติ',
            self::STATUS_CANCELED => 'ยกเลิก',
            self::STATUS_COMPLETE => 'สมบุรณ์',
        ];
    }

    public function getStatusName()
    {
        $status = ListApproval::getStatusItem();
        return $status[$this->approve_status];
    }


    public function getUserCreated()
    {
        return $this->hasOne(Personnel::className(), ['user_id' => 'created_by']);
    }


    public function getJobGroup()
    {
        return $this->hasOne(JobList::className(), ['id' => 'job_list_id']);
    }

    public function countApproverByStatus($status)
    {
        $model = ApproverComfirm::find()->where([
            'active' => ApproverComfirm::ACTIVE_YES,
            'pk_key' => $this->id,
            'approve_status' => $status,
            'approve_status' => $status,
        ])->count();
        return $model;
    }

    /**
     * หารายชื่อผู้ที่มีสิทธิ์อนุมัติเอกสารทึ้งหมด
     * @return array
     */
    public function getActiveApproverItems()
    {
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
                'name' => $model->approveFullname,
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
     * หา id  รายการที่ผู้ใช้งานอนุมัติแล้ว ทั้งสถานะอนุม้ติและไม่อนุมัติ
     * @return array
     */
    public function getUserHasApproved()
    {
        $models = ApproverComfirm::find()
            ->where([
                'active' => ApproverComfirm::ACTIVE_YES,
                'pk_key' => $this->id
            ])
            ->all();
        $data = ArrayHelper::map($models, 'id', 'id');
        return $data;
    }

    /**
     * หา id  รายการอนุมัติ ตามสถานะที่ระบุ
     * @return array
     */
    public function getUserHasApprovedByStatus($status)
    {
        $models = ApproverComfirm::find()
            ->where([
                'active' => ApproverComfirm::ACTIVE_YES,
                'pk_key' => $this->id,
                'approve_status' => $status
            ])
            ->all();
        $data = ArrayHelper::map($models, 'id', 'id');
        return $data;
    }

    public function getListApprover()
    {
        return [
            [
                'user_id' => 1,
                'name' => 'Admin',
                'text' => 'ผู้ขอ',
                'position' => 'หัวหน้าบริการหลังการขาย'
            ],
            [
                'user_id' => 4,
                'name' => 'ณัฎฐนภนต์ โอฬารธัชนันท์',
                'text' => 'อนุมัติ 1',
                'position' => 'ผู้จัดการฝ่ายบริการหลังการขาย'
            ],
            [
                'user_id' => 143,
                'name' => 'วชิราภรณ์ ฉากครบุรี',
                'text' => 'อนุมัติ 2',
                'position' => 'เจ้าหน้าที่บุคคลล'
            ],
            [
                'user_id' => 5,
                'name' => '	ฐิติระวี โอฬารธัชนันท์',
                'text' => 'อนุมัติ 3',
                'position' => 'ผู้จัดการฝ่ายทรัพยากรบุคคล'
            ]

        ];
    }

    public function getFirstApprover()
    {
        if (!$this->isNewRecord) {
            $model = $this->getListApprover();
            return array_shift($model);
        } else {
            $model = ApproverComfirm::find()
                ->where([
                    'active' => ApproverComfirm::ACTIVE_YES,
                    'pk_key' => $this->id
                ])->orderBy(['seq' => SORT_ASC])
                ->limit(1)
                ->one();
            return [
                'user_id' => $model->approve_user_id,
                'name' => $model->approveFullname,
                'position' => 'Position',
                'seq' => $model->seq,
                'approve_date' => $model->approve_date,
                'approve_status' => $model->approve_status,
                'active' => $model->active,
            ];
        }
    }

    public function getCurrentApprover()
    {
        // if ($this->approve_status != self::STATUS_APPROVED) {
        $model = ApproverComfirm::find()
            ->where([
                'active' => ApproverComfirm::ACTIVE_YES,
                'pk_key' => $this->id,
                'seq' => ($this->approve_seq+1),
            ])
            ->limit(1)
            ->asArray()
            ->one();
        return $model;
        // }
    }

    public function getNextApprover()
    {
       // if ($this->approve_status != self::STATUS_APPROVED) {
/*            $model = ApproverComfirm::find()
                ->where([
                    'active' => ApproverComfirm::ACTIVE_YES,
                    'pk_key' => $this->id,
                    'seq' => ($this->approve_seq+2),
                ])
                ->limit(1)
                ->asArray()
                ->one();
            return $model;*/
       // }
        $allApprovers = $this->getActiveApproverItems();
        return $allApprovers;
    }


    public function getCreatedName()
    {
        $personnel = $this->getPersonnel($this->created_by);
        return $personnel->getFullnameTH();

    }

    public function getPersonnel($id)
    {
        $model = Personnel::findOne(['user_id' => $id]);
        if ($model) {
            return $model;
        }
    }


}

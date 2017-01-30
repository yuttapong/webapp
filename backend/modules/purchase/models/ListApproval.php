<?php

namespace backend\modules\purchase\models;

use common\models\SysDocument;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
    const SCENARIO_DEFAULT = 'default';
    const SCENARIO_CANCEL = 'cancel';
    public $listapprover;
    public $requestBy;
    public $cancelNote;
    public $cancelConfirm;

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
            [['description', 'requestBy', 'approve_name', 'cancelDetails'], 'string'],
            [['subject'], 'string', 'max' => 255],
            [['cancelConfirm'],'boolean'],
            [['cancelNote', 'cancelConfirm'], 'safe'],
            [['approve_status'], 'string', 'max' => 20],
            [['subject', 'description', 'job_list_id', 'approve_status'], 'required'],
            [['approve_status', 'cancelConfirm', 'cancelNote'], 'required', 'on' => self::SCENARIO_CANCEL],
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
            'created_at' => 'วันที่ขอ',
            'created_by' => 'ผู้ขอ',
            'updated_at' => 'แก้ไขล่าสุด',
            'updated_by' => 'แก้ไขโดย',
            'active' => 'Active',
            'approve_user_id' => 'ผู้ขออนุมัติ',
            'approve_user_name' => 'ผู้ขออนุมัติ',
            'approve_seq' => 'ลำดับที่อนุมัติ',
            'user_next_id' => 'ผู้อนุมัติต่อไป',
            'approve_status' => 'สถานะอนุมัติ',
            'cancelNote' => 'เหตุผลในการยกเลิก',
            'cancelConfirm' => 'ยืนยันการยกเลิก',
        ];
    }

    public function getStatusName()
    {
        $status = ListApproval::getStatusItem();
        return $status[$this->approve_status];
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

    public function getUserCreated()
    {
        return $this->hasOne(Personnel::className(), ['user_id' => 'created_by']);
    }


    public function getJobGroup()
    {
        return $this->hasOne(JobList::className(), ['id' => 'job_list_id']);
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

    public function getListApprover($options)
    {
        $listApprovers = SysDocument::getDataApprove(4, $options);
        $data = [];
        foreach ($listApprovers as $key => $item) {
            $data[] = [
                'user_id' => $item['user_id'],
                'name' => $item['user_name'],
                'position' => $item['position_name'],
                'position_level' => $item['position_level'],
            ];
        }
        return $data;

        /*

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

                ];*/
    }

    public function getCurrentApprover()
    {
        $model = ApproverComfirm::find()
            ->where([
                'active' => ApproverComfirm::ACTIVE_YES,
                'pk_key' => $this->id,
                'seq' => ($this->approve_seq + 1),
            ])
            ->limit(1)
            ->asArray()
            ->one();
        return $model;
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

    public function isCompleteApprove()
    {
        $countAllapprover = count($this->getActiveApproverItems());
        $countUserApproved = $this->countApproverByStatus(ApproverComfirm::STATUS_APPROVED);
        if ($countAllapprover == $countUserApproved) {
            return true;
        } else {
            return false;
        }
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
                'comment' => $model->comment,
                'active' => $model->active,
            ];
        }
        return $data;
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

    public function getStatusNameColor()
    {
        $html = '';
        if ($this->approve_status == ListApproval::STATUS_PENDING) {
            $html = Html::tag('div', $this->statusName, ['class' => 'label label-warning']);
            if ($this->approve_name) {
                $html .= Html::tag('div', '(' . $this->approve_name . ')', ['style' => 'margin-top:5px;font-size:12px']);
            }
        }
        if ($this->approve_status == ListApproval::STATUS_PROCESSING) {
            $html = Html::tag('div', $this->statusName, ['class' => 'label label-warning']);
            if ($this->approve_name) {
                $html .= Html::tag('div', '(' . $this->approve_name . ')', ['style' => 'margin-top:5px;font-size:12px']);
            }
        }

        if ($this->approve_status == ListApproval::STATUS_APPROVED) {
            $html = Html::tag('div', $this->statusName, ['class' => 'label label-success']);
        }
        if ($this->approve_status == ListApproval::STATUS_REJECTED) {
            $html = Html::tag('div', $this->statusName, ['class' => 'label label-danger']);
        }

        switch ($this->approve_status) {
            case ListApproval::STATUS_DRAFT:
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-default']);
                if ($this->approve_name) {
                    $html .= Html::tag('div', '(' . $this->approve_name . ')', ['style' => 'margin-top:5px;font-size:12px']);
                }
                break;

            case ListApproval::STATUS_PENDING :
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-warning']);
                if ($this->approve_name) {
                    $html .= Html::tag('div', '(' . $this->approve_name . ')', ['style' => 'margin-top:5px;font-size:12px']);
                }
                break;
            case ListApproval::STATUS_PROCESSING:
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-default']);
                if ($this->approve_name) {
                    $html .= Html::tag('div', '(' . $this->approve_name . ')', ['style' => 'margin-top:5px;font-size:12px']);
                }
                break;
            case ListApproval::STATUS_CANCELED:
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-danger']);
                break;
            case ListApproval::STATUS_REJECTED:
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-danger']);
                break;
            case ListApproval::STATUS_APPROVED:
                $html = Html::tag('div', $this->statusName, ['class' => 'label label-success']);
                break;
        }
        return Html::tag('div', $html, ['align' => '']);
    }

    /**
     *
     */
    public function implodeCancelDetail()
    {
        $detail = [
            'id' => $this->id,
            'cancelBy' => \Yii::$app->user->id,
            'cancelAt' => time(),
            'note' => $this->cancelNote,
            'user' => $this->getPersonnel(\Yii::$app->user->id)->getFullnameTH()
        ];
        $this->cancelDetails = serialize($detail);
    }

    public function explodeCancelDetail()
    {
        return unserialize($this->cancelDetails);
    }


    /**
     * สามารถยกเลิกเอกสารได้
     * @return bool
     */
    public function canCancel()
    {
        $status = [
            ListApproval::STATUS_PROCESSING,
            ListApproval::STATUS_DRAFT,
            ListApproval::STATUS_PENDING,
        ];
        return in_array($this->approve_status, $status);
    }

    /**
     * สามารถอนุมัติเอกสารได้
     * @return bool
     */
    public function canApprove()
    {
        $status = [
            ListApproval::STATUS_PROCESSING,
            ListApproval::STATUS_PENDING,
        ];
        return in_array($this->approve_status, $status);
    }



    /**
     * สามารถแก้ไขอกสารได้
     * @return bool
     */
    public function canUpdate()
    {
        $status = [
            ListApproval::STATUS_DRAFT,
            ListApproval::STATUS_PROCESSING,
            ListApproval::STATUS_PENDING,
        ];

        return in_array($this->approve_status, $status);
    }


}

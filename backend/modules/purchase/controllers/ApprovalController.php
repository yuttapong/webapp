<?php

namespace backend\modules\purchase\controllers;

use backend\modules\purchase\models\ApproverComfirm;
use backend\modules\purchase\models\JobList;
use backend\modules\purchase\models\ListApproval;
use backend\modules\purchase\models\ListApprovalSearch;
use backend\modules\purchase\models\Personnel;
use common\models\ListMessage;
use common\siricenter\thaiformatter\ThaiDate;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

class ApprovalController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $searchModel = new ListApprovalSearch(['active' => 1]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * สร้างใบขออนุมัติใหม่
     * ระบบจะทำการหารายชื่อผู้ใช้มาแสดง และบันทึกรายชื่อผู้อนุมัติทั้งหมดลงฐานข้อมูล พร้อมกับบันทึกรายการแจ้งเตือน
     * ไปยังระบบแจ้งเตือนส่วนกลางด้วย
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model = new ListApproval();


        $personnel = Personnel::findOne(['user_id' => Yii::$app->user->id]);
        $model->created_by = Yii::$app->user->id;
        $model->requestBy = $personnel->fullnameTH;

        $joblistItem = ArrayHelper::map(JobList::find()
            ->where(['status' => 1])
            ->orderBy(['name' => SORT_ASC])
            ->all()
            , 'id', 'name');


        // Insert
        if (Yii::$app->request->post() && $model->load(Yii::$app->request->post())) {
            $nowTimestamp = time();

            $listapprover = isset($_POST['ListApproval']['listapprover']) ? $_POST['ListApproval']['listapprover'] : [];

            $model->active = ListApproval::ACTIVE_YES;
            $model->created_by = Yii::$app->user->id;
            $model->created_at = $nowTimestamp;
            $model->updated_at = $nowTimestamp;
            $model->updated_by = Yii::$app->user->id;
            $model->approve_status = ListApproval::STATUS_PENDING;
            $model->approve_seq = $listapprover[0]['seq'];
            $model->approve_user_id = $listapprover[0]['user_id'];


            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($model->save()) {
                    if (count($listapprover) > 0) {
                        foreach ($listapprover as $key => $item) {
                            if (($item['approve_status']) != '') {
                                // update
                                $ap = ApproverComfirm::find()
                                    ->where([
                                        'pk_key' => $model->id,
                                        'slug' => ApproverComfirm::DOCUMENT_GENERAL_PR,
                                        'active' => ApproverComfirm::ACTIVE_YES,
                                        'approve_user_id' => $item['user_id'],
                                    ])
                                    ->one();
                                $ap->save();
                            } else {
                                // add
                                $ap = new ApproverComfirm();
                                $ap->slug = ApproverComfirm::DOCUMENT_GENERAL_PR;
                                $ap->pk_key = $model->id;
                                $ap->approve_status = ApproverComfirm::STATUS_PENDING;
                                $ap->approve_user_id = $item['user_id'];
                                $ap->seq = $item['seq'];
                                $ap->created_at = $nowTimestamp;
                                $ap->created_by = Yii::$app->user->id;
                                $ap->save();
                            }
                        }
                    }
                    $transaction->commit();
                    //แจ้งเตื่อนที่ระบบแจ้งเตือนข้อความหลัก (table::  sys_list_message)
                    $this->addNotifyApprove($model);


                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }


        }
        return $this->render('create', [
            'model' => $model,
            'listApprover' => $this->sampleListApprover(),
            'joblistItem' => $joblistItem,
        ]);
    }

    private function addNotifyApprove($model)
    {
        $message = new ListMessage();
        $message->slug = ApproverComfirm::DOCUMENT_GENERAL_PR;
        $message->document_id = 4;
        $message->table_key = $model->id;
        $message->user_id = $model->created_by;
        $message->title = Html::a($model->subject, ['purchase/pr/view', 'id' => $model->id]);
        $message->status = 1; // Active: 1 , Inactive: 0
        $message->app_status = 0; // ขออนุมัติ
        $message->link = Url::to(['purchase/pr/view', 'id' => $model->id]);
        $message->type = 0;
        $message->created_at = time();

        //ผู้อนุมัติ
        $modelPerson = new ListApproval();
        $personnel = $modelPerson->getPersonnel($model->approve_user_id);

        $message->user_approver_id = $model->approve_user_id;
        $message->user_approver_name = $personnel->fullnameTH;
        $message->save();
    }

    public function sampleListApprover()
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

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        return $this->render('view', [
            'type' => ApproverComfirm::DOCUMENT_GENERAL_PR,
            'model' => $model,
            'listApprover' => $model->getActiveApproverItems(),
            'listAproved' => $model->getUserHasApproved(),
        ]);
    }

    private function loadModel($id)
    {
        $model = ListApproval::findOne($id);
        return $model;
    }

    /**
     * อนมุัติเอกสาร
     */
    public function actionApprove()
    {

        $approver = Yii::$app->request->post('approver', []);
        $data = [
            'success' => 0
        ];
        if (!empty($approver)) {
            foreach ($approver as $key => $approve) {
                if ($approve['user_id'] != '' && $approve['document'] != '' && Yii::$app->user->id == "{$approve['user_id']}") {
                    $model = ApproverComfirm::find()
                        ->where([
                                'id' => $approve['id'],
                                'pk_key' => $approve['document'],
                                'approve_user_id' => $approve['user_id'],
                                'active' => ApproverComfirm::ACTIVE_YES]
                        )->one();

                    $model->approve_status = $approve['status'];
                    $model->comment = $approve['remark'];
                    $model->approve_date = time();

                    $approve_date = ThaiDate::widget([
                        'timestamp' => $model->approve_date,
                        'type' => ThaiDate::TYPE_MEDIUM,
                        'showTime' => false
                    ]);

                    if ($model->save()) {
                        $document = ListApproval::findOne($model->pk_key);
                        $listApprovers = $document->getActiveApproverItems();


                        // เปลี่ยนสถานะเอกสารเป็นอนุมัติถ้ามีการอนุมัติครบทุกคน
                        if ($document->isCompleteApprove()) {
                            $document->approve_status = ListApproval::STATUS_APPROVED;
                            $document->approve_user_id = null;
                            $document->approve_seq = null;
                            $document->approve_name = null;
                            $document->save();
                        } else {


                            // เปลี่ยนสถานะเอกสารเป็นไม่อนุมัติถ้ามีคนใดคนหนึ่งไม่อนุมติ และจบการทำงานทันที
                            if ($model->approve_status == ApproverComfirm::STATUS_REJECTED) {
                                $document->approve_status = ListApproval::STATUS_REJECTED;
                                $document->save();
                            }

                            // เปลี่ยนสถานะเมื่อกดปุ่ม
                            if ($model->approve_status == ApproverComfirm::STATUS_APPROVED) {
                                $document->approve_user_id = $listApprovers[$key + 1]['user_id'];
                                $document->approve_seq = $listApprovers[$key + 1]['seq'];
                                $document->approve_status = ListApproval::STATUS_PROCESSING;
                                $personnel = $document->getPersonnel($document->approve_user_id);
                                $document->approve_name = $personnel->fullnameTH;
                                $document->save();
                            }
                        }


                        $this->addNotifyApprove($document);

                        $data = [
                            'success' => 1,
                            'row' => [
                                'documentId' => $model->pk_key,
                                'documentStatus' =>  $document->approve_status,
                                'approve_status' => $model->approve_status,
                                'approve_date' => $approve_date,
                                'approve_name' => $document->approve_name,
                                'comment' => $model->comment,

                            ],
                            'error' => $document->errors,
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
    }

    public function actionCancel($id)
    {
        $model = $this->loadModel($id);
        $model->approve_status = ListApproval::STATUS_CANCELED;
        if (Yii::$app->request->isAjax) {
            if ($model->save()) {
                echo json_encode([
                    'success' => true,
                    'message' => 'successfully canceled. ',
                ]);
            }
        } else {
            if ($model->save()) {
                return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
            }
        }
    }

    private function clearNotifyApprove($model)
    {

    }


}

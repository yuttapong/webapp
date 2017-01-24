<?php

namespace backend\modules\purchase\controllers;

use backend\modules\purchase\models\ApproverComfirm;
use backend\modules\purchase\models\Inventory;
use backend\modules\purchase\models\ListApproval;
use backend\modules\purchase\models\Personnel;
use common\siricenter\thaiformatter\ThaiDate;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use backend\modules\purchase\models\JobList;
use Yii;

class PrController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = ListApproval::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * สร้างใบขออนุมัติใหม่
     * ระบบจะทำการหารายชื่อผู้ใช้มาแสดง และบันทึกรายชื่อผู้อนุมัติทั้งหมดลงฐานข้อมูล พร้อมกับบันทึกรายการแจ้งเตือน
     * ไปยังระบบแจ้งเตือนส่วนกลางด้วย
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionNew()
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


                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                throw $e;
            }


        }

        return $this->render('new', [
            'model' => $model,
            'listApprover' => $this->sampleListApprover(),
            'joblistItem' => $joblistItem,
        ]);
    }


    public function actionView($id)
    {

        $model = $this->loadModel($id);
        $joblistItem = ArrayHelper::map(JobList::find()
            ->where(['status' => 1])
            ->orderBy(['name' => SORT_ASC])
            ->all()
            , 'id', 'name');

        return $this->render('view', [
            'type' => ApproverComfirm::DOCUMENT_GENERAL_PR,
            'model' => $model,
            'listApprover' => $model->getActiveApproverItems(),
            'listAproved' => $model->getUserHasApproved(),
        ]);
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


                        // เปลี่ยนสถานะเอกสารเป็นไม่อนุมัติถ้ามีคนใดคนหนึ่งไม่อนุมติ
                        if ($model->approve_status == ApproverComfirm::STATUS_REJECTED) {
                            $document->approve_status = ListApproval::STATUS_REJECTED;
                        }


                        // เปลี่ยนสถานะเอกสารเป็นอนุมัติถ้ามีการอนุมัติครบทุกคน
                        $countComplete = $document->countApproverByStatus(ApproverComfirm::STATUS_APPROVED);
                        $countProcess = count($document->getActiveApproverItems());
                        if ($countComplete == $countProcess) {
                            $document->approve_status = ListApproval::STATUS_APPROVED;
                        } else {
                            $document->approve_user_id = $listApprovers[$key + 1]['user_id'];
                            $document->approve_seq = $listApprovers[$key + 1]['seq'];
                        }

                        $document->save();

                        $data = [
                            'success' => 1,
                            'row' => [
                                'document' => $model->pk_key,
                                'approve_status' => $model->approve_status,
                                'approve_date' => $approve_date,
                                'comment' => $model->comment,
                            ]
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
    }

    private function addNotifyApprove($model)
    {

    }

    private function clearNotifyApprove($model)
    {

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

    public function getFirstApprover()
    {
        $arrays = $this->sampleListApprover();
        return array_shift($arrays);

    }

    private function loadModel($id)
    {
        $model = ListApproval::findOne($id);
        return $model;
    }

}

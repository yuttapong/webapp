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
            $model->active = ListApproval::ACTIVE_YES;
            $model->created_by = Yii::$app->user->id;
            $model->created_at = $nowTimestamp;
            $model->updated_at = $nowTimestamp;
            $model->updated_by = Yii::$app->user->id;
            $model->approve_status = ListApproval::STATUS_PENDING;

            $transaction = Yii::$app->db->beginTransaction();

            try {

                if ($model->save()) {

                    $listapprover = isset($_POST['ListApproval']['listapprover']) ? $_POST['ListApproval']['listapprover'] : [];
                    if (count($listapprover) > 0) {

                        foreach ($listapprover as $key => $item) {
                            if (($item['approve_status']) > 0) {
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
            'listApprover' => $model->getActiveApproveConfirmItems(),
            'listAproved' => $model->getListUserHasApproved(),
        ]);
    }

    public function actionApprove()
    {
        $approver = Yii::$app->request->post('approver', []);
        $data = [];
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
                    $model->save();
                    $approve_date = ThaiDate::widget([
                        'timestamp' => $model->approve_date,
                        'type' => ThaiDate::TYPE_MEDIUM,
                        'showTime' => false
                    ]);
                    $data = [
                        'success' => 1,
                        'row' => [
                            'document' => $model->pk_key,
                            'approve_status' => $model->approve_status,
                            'approve_date' => $approve_date,
                            'comment' => $model->comment,
                        ]
                    ];
                    echo json_encode($data);
                }
            }
        }
        echo json_encode($data);
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
                'id' => 4,
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

    private function loadModel($id)
    {
        $model = ListApproval::findOne($id);
        return $model;
    }

}

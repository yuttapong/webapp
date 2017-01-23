<?php

namespace backend\modules\purchase\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\purchase\models\ApproverComfirm;
use backend\modules\purchase\models\JobList;
use backend\modules\purchase\models\ListApproval;
use backend\modules\purchase\models\Personnel;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use Yii;

class DocumentController extends \yii\web\Controller
{
    public function actionNew($t)
    {
        switch ($t) {
            case 'general_pr' :
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
                    $model->approval_status = ListApproval::STATUS_PENDING;

                    $transaction = Yii::$app->db->beginTransaction();

                    try {

                        if ($model->save()) {

                            $listapprover =  isset($_POST['ListApproval']['listapprover'])?$_POST['ListApproval']['listapprover']:[];
                            if (count($listapprover) > 0) {

                                foreach ($listapprover as $key => $item) {
                                    if (($item['approve_status']) > 0) {
                                        $ap = ApproverComfirm::find()
                                            ->where([
                                                'pk_key' => $model->id,
                                                'slug' => ApproverComfirm::DOCUMENT_GENERAL_PR,
                                                'active' => ApproverComfirm::ACTIVE_YES,
                                                'approve_user_id' => $item['id'],
                                            ])
                                            ->one();
                                        $ap->save();

                                    } else {
                                        $ap = new ApproverComfirm();
                                        $ap->slug = ApproverComfirm::DOCUMENT_GENERAL_PR;
                                        $ap->pk_key = $model->id;
                                        $ap->approve_status = ApproverComfirm::STATUS_PENDING;
                                        $ap->approve_user_id = $item['id'];
                                        $ap->seq = $item['seq'];
                                        $ap->created_at = $nowTimestamp;
                                        $ap->created_by = Yii::$app->user->id;
                                        $ap->save();
                                        print_r($ap->errors);

                                    }
                                }

                            }
                                $transaction->commit();
                        }

                    } catch (Exception $e) {
                        $transaction->rollBack();
                        throw $e;
                    }


                }

                return $this->render('form/new', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                    'joblistItem' => $joblistItem,
                ]);
                break;
            case 'pr' :
                $model = new ListApproval();
                return $this->render('form/new', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                ]);
                break;
            default :
                $model = new ListApproval();
                return $this->render('form/new', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                ]);
                break;
        }

    }

    public function actionView($t, $id)
    {
        $model = $this->loadModel($id);
        switch ($t) {
            case 'general_pr' :
              //  $model = new ListApproval();

                $joblistItem = ArrayHelper::map(JobList::find()
                    ->where(['status' => 1])
                    ->orderBy(['name' => SORT_ASC])
                    ->all()
                    , 'id', 'name');
                return $this->render('view', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                    'joblistItem' => $joblistItem,
                ]);
                break;
            case 'pr' :
                $model = new ListApproval();
                return $this->render('form/new', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                ]);
                break;
            default :
                $model = new ListApproval();
                return $this->render('form/new', [
                    'type' => $t,
                    'model' => $model,
                    'listApprover' => $this->sampleListApprover(),
                ]);
                break;
        }

    }

    private function loadModel($id)
    {
        $model = ListApproval::findOne($id);
        return $model;
    }

    public function sampleListApprover()
    {
        return [
            [
                'id' => 1,
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
                'id' => 143,
                'name' => 'วชิราภรณ์ ฉากครบุรี',
                'text' => 'อนุมัติ 2',
                'position' => 'เจ้าหน้าที่บุคคลล'
            ],
            [
                'id' => 5,
                'name' => '	ฐิติระวี โอฬารธัชนันท์',
                'text' => 'อนุมัติ 3',
                'position' => 'ผู้จัดการฝ่ายทรัพยากรบุคคล'
            ]

        ];
    }

}

<?php

namespace backend\modules\purchase\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\purchase\models\JobList;
use backend\modules\purchase\models\ListApproval;
use backend\modules\purchase\models\Personnel;
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
                $model->approver_user_id = Yii::$app->user->id;
                $model->approver_user_name = $personnel->fullnameTH;

                $joblistItem = ArrayHelper::map(JobList::find()
                    ->where(['status'=>1])
                    ->orderBy(['name'=>SORT_ASC])
                   ->all()
                    ,'id','name');
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

    public function sampleListApprover()
    {
        return [
            [
                'id' => 184,
                'name' => 'วีระศักดิ์ เรือนใจหลัก',
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

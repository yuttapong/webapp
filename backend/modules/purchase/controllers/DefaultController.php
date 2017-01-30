<?php

namespace backend\modules\purchase\controllers;

use backend\modules\purchase\models\ListApproval;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `purchase` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {


        $dataProviderApproval = new ActiveDataProvider([
            'query' => ListApproval::find()->orderBy(['created_at' => SORT_DESC])->limit(10)
        ]);


        $approvalCountAll = ListApproval::find()->where([
            'active' => ListApproval::ACTIVE_YES
        ])
            ->orFilterWhere([
                'approve_status' => ListApproval::STATUS_PENDING,
                'approve_status' => ListApproval::STATUS_PROCESSING,
            ])
            ->count();
        $approvalCountThisMonth = ListApproval::find()->where(['active' => ListApproval::ACTIVE_YES])
            ->where([
                'YEAR(FROM_UNIXTIME(created_at))' => date('Y'),
                'MONTH(FROM_UNIXTIME(created_at))' => date('m'),
            ])
            ->count();
        $approvalCountToday = ListApproval::find()->where(['active' => ListApproval::ACTIVE_YES])
            ->where([
                'DATE(FROM_UNIXTIME(created_at))' => date('Y-m-d'),
            ])
            ->count();
        $count = [
            'approval' => [
                'countAll' => $approvalCountAll,
                'countThisMonth' => $approvalCountThisMonth,
                'countToday' => $approvalCountToday,
            ]
        ];


        return $this->render('index', [
            'dataProviderApproval' => $dataProviderApproval,
            'count' => $count
        ]);
    }
}

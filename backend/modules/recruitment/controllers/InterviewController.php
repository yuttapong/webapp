<?php

namespace backend\modules\recruitment\controllers;

use backend\modules\recruitment\models\RcmAppForm;
use backend\modules\org\models\OrgPersonnel;

class InterviewController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionAccepted(){
        return $this->render('accepted');
    }

    public function actionCreate($id)
    {
        $model = $this->findModel($id);
        $modelPersonnel = OrgPersonnel::findOne($model->personnel_id);
        return $this->render('create', [
            'model' => $model,
            'modelPersonnel' => $modelPersonnel,
        ]);
    }

    /**
     * Finds the RcmAppForm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RcmAppForm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RcmAppForm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

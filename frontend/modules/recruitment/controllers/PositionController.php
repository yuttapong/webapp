<?php

namespace frontend\modules\recruitment\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use  backend\modules\recruitment\models\RcmAppManpower;




class PositionController extends \yii\web\Controller
{


    public $layout = 'recruitment';

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RcmAppManpower::find()
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single  model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }




    private function findModel($id){
        return RcmAppManpower::findOne($id);
    }







}

<?php

namespace backend\modules\rems\controllers;

class LoanController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionNew()
    {
        return $this->render('index');
    }
}

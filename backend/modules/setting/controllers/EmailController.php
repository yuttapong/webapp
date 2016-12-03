<?php

namespace backend\modules\setting\controllers;

class EmailController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }


    public function actionSmtp()
    {
        return $this->render('index');
    }

}

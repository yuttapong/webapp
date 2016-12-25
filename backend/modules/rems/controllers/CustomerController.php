<?php

namespace backend\modules\rems\controllers;

class CustomerController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

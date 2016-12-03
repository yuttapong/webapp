<?php

namespace api\modules\v1\controllers;

class ResponseController extends \yii\rest\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

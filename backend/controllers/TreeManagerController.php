<?php

namespace backend\controllers;

class TreeManagerController extends \yii\web\Controller
{
    public  $layout = 'full-page';
    public function actionIndex()
    {
        return $this->render('index');
    }

}

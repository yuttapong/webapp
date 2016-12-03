<?php

namespace backend\modules\report\controllers;

class ProjectController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

<?php
namespace backend\modules\tree\controllers;

class TreeController extends \yii\web\Controller
{
   // public  $layout = 'full-page';
    public function actionIndex()
    {
        return $this->render('index');
    }

}

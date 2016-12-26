<?php

namespace backend\modules\construction\controllers;

use yii\web\Controller;

/**
 * Default controller for the `construction` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
       $this->layout = 'home';

        return $this->render('index');
    }
}

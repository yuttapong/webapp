<?php

namespace frontend\modules\recruitment\controllers;

use yii\web\Controller;

/**
 * Default controller for the `recruitment` module
 */
class DefaultController extends Controller
{

    public $layout = 'recruitment';

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

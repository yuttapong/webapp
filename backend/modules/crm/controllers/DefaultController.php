<?php

namespace backend\modules\crm\controllers;
use Yii;
use yii\web\Controller;
use backend\modules\crm\models\CustomerSearch;
use backend\modules\crm\models\Customer;

/**
 * Default controller for the `crm` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new CustomerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'model' => new Customer(),
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);

       // return $this->redirect(['response/index']);
    }
}

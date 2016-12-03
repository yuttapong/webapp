<?php

namespace backend\modules\fix\controllers;

use yii\web\Controller;
use common\models\ListMessage;
use common\models\ListMessageSearch;


/**
 * Default controller for the `fix` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
    	$searchModel = new ListMessageSearch();
    	
    	$app['ListMessageSearch']['slug']='fix';
    	$app['ListMessageSearch']['user_apprever_id']=\Yii::$app->user->id;
    	$app['ListMessageSearch']['app_status']=0;
    	$dataProvider = $searchModel->search($app);
    	

        return $this->render('index',[
        	 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    
}

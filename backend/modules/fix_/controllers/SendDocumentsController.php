<?php

namespace backend\modules\fix\controllers;

use Yii;
use backend\modules\fix\models\SendDocuments;
use backend\modules\fix\models\SendDocumentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\fix\models\InformJobSearch;

/**
 * SendDocumentsController implements the CRUD actions for SendDocuments model.
 */
class SendDocumentsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SendDocuments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SendDocumentsSearch();
       $params=Yii::$app->request->queryParams;
       $params['SendDocumentsSearch']['recipient_user_id']=Yii::$app->user->id;
       //echo '<pre>';
       //print_r($params);
       //echo '</pre>';
       // Yii::$app->user->id
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SendDocuments model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SendDocuments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SendDocuments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SendDocuments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SendDocuments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the SendDocuments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SendDocuments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SendDocuments::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /*
     * รับทราบเอกสาร
     */
    public function actionSendAcknowledge($id) {
    	$modelSen = $this->findModel($id);
    	
    	$post=Yii::$app->request->post();
    	if($post){
    		$option=unserialize($modelSen->option);
    		if(!empty($post['SendDocuments']['option'])){
    			$old_option=unserialize($modelSen->option);
    			foreach ($post['SendDocuments']['option']  as $key=>$val){
    				if($key=='text_khow'){
    					$option['text_khow']=$val;
    				}
    			} 
    			$modelSen->option=serialize($option);
    			$modelSen->is_khow=$post['SendDocuments']['is_khow'];
    			$modelSen->save();
    			
    			$modelisApp= \common\models\ListMessage::findOne(
    				['table_name' => $modelSen->table_name,'table_key'=>$modelSen->table_key,'table_key2'=>$modelSen->id]
    					) ;
    			$modelisApp->app_status=2;
    			$modelisApp->status=1;
    			$modelisApp->save();
    			echo 1;
    			exit();
    			
    		}
    	}
    	$searchModel = new InformJobSearch();
    	$arr['InformJobSearch']['inform_fix_id']=$modelSen->table_key;
    	$dataProvider = $searchModel->search ( $arr);
    	
    	return $this->renderAjax( '_form-sen-acknowledge', [
    			'modelSen' => $modelSen,
    			'model' => $this->findModel ( $id ),
    			'dataProvider' => $dataProvider
    
    	] );
    
    }
}

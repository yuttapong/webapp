<?php

namespace backend\modules\fix\controllers;

use Yii;
use backend\modules\fix\models\ListApprover;
use backend\modules\fix\models\ListApproverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\org\models\OrgApprove;
use backend\modules\fix\models\InformFix;
use backend\modules\fix\models\ListApproverJob;
use GuzzleHttp\json_decode;
use backend\modules\fix\models\InformJob;

/**
 * ListApproverController implements the CRUD actions for ListApprover model.
 */
class ListApproverController extends Controller
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
     * Lists all ListApprover models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ListApproverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ListApprover model.
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
     * Creates a new ListApprover model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($inform_fix_id)
    {
        $model = new ListApprover();

       /* if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        //ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
        $option['approver_user_id']='158';
        $option['company_id']=3;
        $option['site_id']=5;
        $option['level']=0;
        $listApprove = OrgApprove::getDataOrganization(158, 1, $option);
        $modelFix = InformFix::findOne ( $inform_fix_id );
        $model->list=$modelFix->title;
        $model->inform_fix_id=$inform_fix_id;
        $post=Yii::$app->request->post ();
        if ($post) { 
        	$model->load($post);
        	
        	if($model->save()){
	        	$arrJob=json_decode($model->job_selected);
	        	if(count($arrJob)>0){
	        		foreach ($arrJob as $vJob){ 
	        			$modeljob = InformJob::findOne($vJob);
	        			$modeljob->job_status=0;
	        			$modeljob->save();
	        		} 
	        	}
	        	$modelisApp=new \common\models\ListApprover();
	        	$modelisApp->titie=$modelFix->title; 
	        	$modelisApp->user_id=$modelFix->created_by;
	        	$modelisApp->table_name='fix_inform_fix';
	        	$modelisApp->table_key=$modelFix->id;
	        	$modelisApp->module_id='11';
	        	$modelisApp->save();
	        	
        	}
        }
        
        if (Yii::$app->request->isAjax) {
        	return $this->renderAjax('create', [
        			'model' => $model,
        			'listApprove' =>$listApprove,
        			'inform_fix_id' => $inform_fix_id,
        			'modelFix' => $modelFix,
        	]);
        }else{
        	return $this->render('create', [
        			'model' => $model,
        			'listApprove' =>$listApprove,
        			'inform_fix_id' => $inform_fix_id,
        			'modelFix' => $modelFix,
        	]);
        }
    }

    /**
     * Updates an existing ListApprover model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$inform_fix_id) {
        $model = $this->findModel($id);
        //ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
        $option['approver_user_id']='158';
        $option['company_id']=3;
        $option['site_id']=5;
        $option['level']=0;
        $listApprove = OrgApprove::getDataOrganization(158, 1, $option);
        $OldArrJob=json_decode($model->job_selected);
        $modelFix = InformFix::findOne ( $inform_fix_id );
        $post=Yii::$app->request->post();

    	//$va=$model->load($post);

        if($post){
        	
	    	/*$job_check=true;
	    	if(isset($post['ListApprover']['job_selected'])&&$post['ListApprover']['job_selected']=='[]'){
	    		$job_check=false;
	    		$model->job_selected=null;
	    	}*/
	    	
	    	$model->load($post);
	    	$valid=$model->validate()   ;
	 		echo '<pre>';
	    	print_r($model->errors);
	    	echo '</pre>';
	    	
	        if ($valid) { 
	        	$model->save();
	        	$newArrJob=json_decode($model->job_selected);
	        	//ถ้ามมีในอันเก่าไม่ต้องทำอะไร
	        	$arrAllJob=[];
	        	if(count($OldArrJob)>0){
	        		foreach ($OldArrJob as $vJob){
	        			$modeljob = InformJob::findOne($vJob);
	        			$modeljob->job_status=null;
	        			$modeljob->save();
	        		}
	        	}
	        	
	        	if(count($newArrJob)>0){
	        		foreach ($newArrJob as $vJob){
	        			$modeljob = InformJob::findOne($vJob);
	        			$modeljob->job_status=0;
	        			$modeljob->save();
	        		}
	        		 
	        	}
	        	
	            return $this->redirect(['view', 'id' => $model->id]);
	            
	        } 
        }
        
        if (Yii::$app->request->isAjax) {
        	return $this->renderAjax('create', [
        			'model' => $model,
        			'listApprove' =>$listApprove,
        			'inform_fix_id' => $inform_fix_id,
        			'modelFix' => $modelFix,
        	]);
        }else{
            return $this->render('update', [
                'model' => $model,
            		'listApprove' =>$listApprove,
            		'inform_fix_id' => $inform_fix_id,
            		'modelFix' => $modelFix,
            ]);
        }
        
    }

    /**
     * Deletes an existing ListApprover model.
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
     * Finds the ListApprover model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ListApprover the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ListApprover::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\modules\fix\controllers;

use Yii;
use backend\modules\fix\models\InformJob;
use backend\modules\fix\models\InformJobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Model;
use backend\modules\fix\models\InformMaterial;
use backend\modules\org\models\OrgApprove;

/**
 * InformJobController implements the CRUD actions for InformJob model.
 */
class InformJobController extends Controller
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
     * Lists all InformJob models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InformJobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single InformJob model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	if (Yii::$app->request->isAjax) {
    		return $this->renderAjax('view', [
    				'model' => $this->findModel($id),
    		]);
    	}
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InformJob model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($inform_fix_id)
    {
        $model = new InformJob();
		$modelInven=[];
		$post=Yii::$app->request->post ();
		if ($post) {
			$InformJob['InformJob']=$post['InformJob'];
			$model->inform_fix_id=$inform_fix_id;
			$model->load($InformJob);
			if(isset($post['InformMaterial']) && count($post['InformMaterial'])>0){
				$modelInven=$this->ValidateMaterial($inform_fix_id,$model->id,$post);
			}
			$valid = $model->validate();
			$valid = Model::validateMultiple($modelInven) && $valid;
			$transaction = Yii::$app->db->beginTransaction();
			try  {
				if ($valid) {
					$model->save();
					$this->Material($inform_fix_id, $model->id, $post);
					$transaction->commit();
					return '1';
				}
			} catch (Exception $e) {
				$transaction->rollBack();
			}
		}
		
        if (Yii::$app->request->isAjax) {
        	return $this->renderAjax ( 'create', [
        			'model' => $model,
        			'modelInven' => $modelInven,
        	] );
        }else{
        	return $this->render('create', [
        			'model' => $model,
        			'modelInven' => $modelInven,
        	]);
        }
    }
    /**
     * Updates an existing InformJob model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($inform_fix_id,$job_id){
    	$model = $this->findModel($job_id);
    	$modelInven=$model->material;
    	$post=Yii::$app->request->post ();
    	echo '<pre>';
    	print_r($_POST);
    	echo '</pre>';
    	//exit();
    	
    	if (Yii::$app->request->post ()) {
    		$model->load(Yii::$app->request->post());
    		if(isset($post['InformMaterial']) && count($post['InformMaterial'])>0){
    			$modelInven=$this->ValidateMaterial($model->inform_fix_id,$job_id,$post);
    		}
    		$valid = $model->validate();
    		$valid = Model::validateMultiple($modelInven) && $valid;
    		$transaction = Yii::$app->db->beginTransaction();
    		try  {
    			$model->inform_fix_id=$inform_fix_id;
    			if ($valid) {
    				$model->save();
    				$this->Material($model->inform_fix_id,$job_id, $post);
    				$transaction->commit();
    				if (Yii::$app->request->isAjax) {
    					return '1';
    				}else{
    					return $this->redirect(['view', 'id' =>$job_id]);
    				}
    			}
    		} catch (Exception $e) {
    			$transaction->rollBack();
    		}
    	}
    	if (Yii::$app->request->isAjax) {
    		return $this->renderAjax ( 'update', [
    				'model' => $model,
    				'modelInven' => $modelInven,
    		] );
    	}else{
    		return $this->render('update', [
    				'model' => $model,
    				'modelInven' => $modelInven,
    		]);
    	}
    }
    public function ValidateMaterial($inform_id,$job_id,$post){
    	$modelInven=[];
    	if(isset($post['InformMaterial']) && count($post['InformMaterial'])>0){
    		unset($modelInven);
    		foreach($post['InformMaterial'] as $key=>$adaptor){
    			if(isset($adaptor['id']) && $adaptor['id'] !='' ){
    				$adaptors = InformMaterial::findOne ( $adaptor['id'] );
    			}else{
    				$adaptors  = new InformMaterial();
    			}
    			$adaptors->inform_fix_id=$inform_id;
    			$adaptors->inform_job_id=$job_id;
    			$adaptors->name=$adaptor['name'];
    			$modelInven[]=$adaptors;
    		}
    	}
    	return  $modelInven;
    }
    public function Material($inform_id,$job_id,$post) {
    	if(isset($post['inv']['check']) &&count($post['inv']['check'])>0){
    		foreach($post['inv']['check'] as $key=>$inv){
    			if($inv=='add' ){
    				$adaptors  = new InformMaterial();
    				$adaptors->inform_fix_id=$inform_id;
    				$adaptors->inform_job_id=$job_id;
    				$adaptors->name=$post['InformMaterial'][$key]['name'];
    				$adaptors->unit=$post['InformMaterial'][$key]['unit'];
    				$adaptors->qty=$post['InformMaterial'][$key]['qty'];
    				$adaptors->save();
    				//$modelInven[]=$adaptors;
    			}elseif($inv=='edit'){
    				$adaptors = InformMaterial::findOne ( $post['InformMaterial'][$key]['id'] );
    				$adaptors->inform_fix_id=$inform_id;
    				$adaptors->inform_job_id=$job_id;
    				$adaptors->name= $post['InformMaterial'][$key]['name'];
    				$adaptors->name=$post['InformMaterial'][$key]['name'];
    				$adaptors->unit=$post['InformMaterial'][$key]['unit'];
    				$adaptors->qty=$post['InformMaterial'][$key]['qty'];
    				$adaptors->save();
    				//$modelInven[]=$adaptors;
    			}elseif($inv=='del'){
    				$adaptors = InformMaterial::findOne($post['inv']['key'][$key] );
    				$adaptors->delete ();
    			}
    		}
    	}
    }

  

    /**
     * Deletes an existing InformJob model.
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
     * Finds the InformJob model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InformJob the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InformJob::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

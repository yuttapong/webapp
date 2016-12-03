<?php

namespace backend\modules\fix\controllers;

use Yii;
use common\models\Home;
use backend\modules\fix\models\HomeSearch;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use backend\modules\crm\models\Customer;

/**
 * HomeController implements the CRUD actions for Home model.
 */
class HomeController extends Controller
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
     * Lists all Home models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
        	$keys = \Yii::$app->request->post('editableKey');
        	$model = Home::findOne($keys);
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	 $editableAttribute=trim(Yii::$app->request->post('editableAttribute'));
        	 
        	$post = [];
        	$posted = current($_POST['Home']);
        	$post = ['Home' => $posted];
        	 
        	if ($model->load($post)) {
        		
        		if($editableAttribute=='customer_id'){
        		
        			$mCus =Customer::findOne($model->customer_id);
        			 $model->customer_name = $mCus->prefixname.' '.$mCus->firstname.' '.$mCus->lastname;
        	
        		}
        		
        		$model->save();
        		$value='';
		        if(\Yii::$app->request->post('editableKey')=='home_no'){
		        		$value = $model->home_no;
		        }else if(\Yii::$app->request->post('editableKey')=='plan_no'){
		        	$value = $model->plan_no;
		        }else if(\Yii::$app->request->post('editableKey')=='customer_id'){
		        	$value = $model->customer_id;
		        }
        		 
        		return ['output'=>$value, 'message'=>''];
        		 
        
        	} else {
        		return ['output'=>'', 'message'=>''];
        	}
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Home model.
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
     * Creates a new Home model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Home();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Home model.
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
     * Deletes an existing Home model.
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
     * Finds the Home model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Home the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Home::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionCustomersList($q = null, $id = null) {
    
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    	$out = ['results' => ['id' => '', 'text' => '']];
    	if (!is_null($q)) {
    		$query = new Query();
    		$query->select("id, prefixname ,firstname,lastname")
    		->from('crm_customer')
    		->andFilterWhere([
    				'or',
    				['like', 'firstname', $q],
    				['like', 'lastname', $q],
    		])

    		->limit(20);
    		$command = $query->createCommand();
    		$data = $command->queryAll();
    		$arrData=[];
    		foreach ($data as $val){  
    			$arrData[$val['id']]['id']=$val['id'];
    
    			$arrData[$val['id']]['text']=$val['prefixname'].' '.$val['firstname'].' '.$val['lastname'];
    		}
    		 
    		$out['results'] = array_values($arrData);
    	}
    	elseif ($id > 0) {
    		$model=Customer::find($id);
    		$out['results'] = ['id' => $id, 'text' => $model->prefixname.' ' .$model->firstname.' '.$model->lastname ];
    	}
    	return $out;
    }

    public function actionGetHome() {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $province_id = $parents[0];
                $out = $this->getHome($province_id);
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }
        }
        echo Json::encode(['output'=>'', 'selected'=>'']);
    }

    protected function getHome($id){
        $datas = Home::find()->where(['project_id'=>$id])->all();
        $obj = [];
        foreach ($datas as $key => $value) {
            $home_no = $value->home_no>0 ? " ::  เลขที่ {$value->home_no}":'';
            array_push($obj, ['id'=>$value->id,'name'=>'แปลง ' . $value->plan_no . $home_no]);
        }

        return $obj;
    }

}

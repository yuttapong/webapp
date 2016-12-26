<?php

namespace backend\modules\purchase\controllers;

use Yii;
use backend\modules\purchase\models\Vendor;
use backend\modules\purchase\Models\VendorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


/**
 * VendorController implements the CRUD actions for Vendor model.
 */
class VendorController extends Controller
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
     * Lists all Vendor models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$searchModel = new VendorSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	
    	if (Yii::$app->request->post('hasEditable')) {
    		$keys = Yii::$app->request->post('editableKey');
    		$model = Vendor::findOne($keys);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
 
        $post = [];
        $posted = current($_POST['Vendor']);
        $post = ['Vendor' => $posted];
        
         if ($model->load($post)) {
         		$model->save();
         
            $value = $model->company;

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
    public function actionVendorList($q = null, $id = null) {
    
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    	$out = ['results' => ['id' => '', 'text' => '']];
    	if (!is_null($q)) {
    		$query = new Query();
    		$query->select("id, master_id ,company")
    		->from('psm_vendor')
    		->where(['like', 'company', $q])
    		->limit(20);
    		$command = $query->createCommand();
    		$data = $command->queryAll();
    		$arrData=[];
    		foreach ($data as $val){
    			
    			if($val['master_id']==$val['id']){
    				$text=$val['master_id'].':'.$val['company'];
    			}else{
    				$text=$val['company'];
    			}
    			$arrData[$val['id']]['id']=$val['id'];
    			
    			$arrData[$val['id']]['text']=$text;
    		}
    	
    		$out['results'] = array_values($arrData);
    	}
    	elseif ($id > 0) {
    		$model=Vendor::find($id);
    		$out['results'] = ['id' => $id, 'text' => $model->master_id.':' .$model->company];
    	}
    	return $out;
    }
    /**
     * Displays a single Vendor model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Vendor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Vendor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Vendor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Vendor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public  function  actionMappingVendor($id){
    	echo 'ddd';
    	
    }
 

    /**
     * Finds the Vendor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Vendor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Vendor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

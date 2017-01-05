<?php

namespace backend\modules\purchase\controllers;

use backend\modules\purchase\models\InventoryPrice;
use Dompdf\Exception;
use Yii;
use backend\modules\purchase\models\Inventory;
use backend\modules\purchase\models\InventorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


/**
 * InventoryController implements the CRUD actions for Inventory model.
 */
class InventoryController extends Controller
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
     * Lists all Inventory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post('hasEditable')) {
        	$keys = Yii::$app->request->post('editableKey');
        	$model = Inventory::findOne($keys);
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        
        	$post = [];
        	$posted = current($_POST['Inventory']);
        	$post = ['Inventory' => $posted];
        
        	if ($model->load($post)) {
        		$model->save();
        		 
        		$value = $model->name;
        
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
     * Displays a single Inventory model.
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
     * Creates a new Inventory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inventory();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $model->save();
                $prices = Yii::$app->request->post();
                foreach ($prices['Inventory']['prices'] as $key => $val) {

                }

            } catch (Exception $e ) {

            }


            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Inventory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->prices = InventoryPrice::find()->where(['inventory_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Inventory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Inventory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Inventory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inventory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionInventoryList($q = null, $id = null) {
    
    	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    	$out = ['results' => ['id' => '', 'text' => '']];
    	if (!is_null($q)) {
    		$query = new Query();
    		$query->select("id, master_id ,name,unit_name")
    		->from('psm_inventory')
    		->where(['like', 'name', $q])
    		->limit(20);
    		$command = $query->createCommand();
    		$data = $command->queryAll();
    		$arrData=[];
    		foreach ($data as $val){
    			 
    			if($val['master_id']==$val['id']){
    				$text=$val['master_id'].':'.$val['name'].' '.$val['unit_name'];
    			}else{
    				$text=$val['name'];
    			}
    			$arrData[$val['id']]['id']=$val['id'];
    			 
    			$arrData[$val['id']]['text']=$text;
    		}
    		 
    		$out['results'] = array_values($arrData);
    	}
    	elseif ($id > 0) {
    		$model=Inventory::find($id);
    		$out['results'] = ['id' => $id, 'text' => $model->master_id.':' .$model->name];
    	}
    	return $out;
    }
  
    
}

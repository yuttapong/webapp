<?php

namespace backend\modules\fix\controllers;

use Yii;
use backend\modules\fix\models\Prin;
use backend\modules\fix\Models\PrinSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\fix\models\PrinDetail;
use backend\modules\purchase\models\Inventory;
use yii\helpers\Json;
use backend\modules\fix\models\PrinDetailSearch;
use yii\web\Response;
use yii\db\Query;
use backend\modules\purchase\models\Vendor;
use backend\modules\purchase\models\InventoryPrice;
use yii\helpers\ArrayHelper;
use backend\modules\fix\models\Poin;
use backend\modules\fix\models\PoinDetail;

/**
 * PrinController implements the CRUD actions for Prin model.
 */
class PrinController extends Controller
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
    public  function actionShowVendor($id,$view){

    	$model = PrinDetail::findOne($id);
    	$modelVendor=ArrayHelper::map($this->getVender($model->inventory_id),'id','name');
    	
    	//echo  '<pre>';
    	//print_r($modelVendor);
    	//echo  '</pre>';
    	return $this->renderAjax ( 'vendor-inventery', [
    			'model' => $model,
    			'modelVendor' => $modelVendor,
    			'view'=>$view,
    			'id'=>$id,
    	
    
    	] );
    
    }
    /**
     * Lists all Prin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Prin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$searchModel = new PrinDetailSearch();
    	$get['PrinDetailSearch']['prin_id']=$id;
    	$dataProvider = $searchModel->search($get);
    	if (Yii::$app->request->post('hasEditable')) {
    		$keys = Yii::$app->request->post('editableKey');
    		$model = PrinDetail::findOne($keys);
    		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    	
    	
    		$post = [];
    		$posted = current($_POST['PrinDetail']);
    		$post = ['PrinDetail' => $posted];
    	
    		if ($model->load($post)) {
    			$model->save();
    			 
    			$value = $model->is_confirm;
    	
    			return ['output'=>$value, 'message'=>''];
    	
    			 
    		} else {
    			return ['output'=>'', 'message'=>''];
    		}
    	}
        return $this->render('view', [
            'model' => $this->findModel($id),
        		'searchModel' => $searchModel,
        		'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Prin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Prin();
        $modelInven = [new PrinDetail];
        $post=Yii::$app->request->post();
          echo '<pre>';
      	print_r($_POST);
      	echo '</pre>';
        
        if ($model->load(Yii::$app->request->post()) ) {
        	 $model->save();
        	$this->Material($model->id, $post);
        	
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
    
            return $this->render('create', [
                'model' => $model,
            	'modelInven' => (empty($modelInven)) ? [new PrinDetail] : $modelInven,
            ]);
        }
    }
    public function Material($prid_id,$post) {
    	if(isset($post['inv']['check']) &&count($post['inv']['check'])>1){
    		foreach($post['inv']['check'] as $key=>$inv){
    			if($key>0){
	    			if($inv=='' ){
	    				$adaptors  = new PrinDetail();
	    				$adaptors->prin_id=$prid_id;
	    				$adaptors->inventory_id=$post['PrinDetail'][$key]['inventory_id'];
	    				$adaptors->inventory_name=$post['PrinDetail'][$key]['inventory_name'];
	    				$adaptors->qty=$post['PrinDetail'][$key]['qty'];
	    				$adaptors->unit_id=$post['PrinDetail'][$key]['unit_id'];
	    				$adaptors->home_id=$post['PrinDetail'][$key]['home_id'];
	    				$adaptors->job_list_id=$post['PrinDetail'][$key]['job_list_id'];
	    				$adaptors->job_name=$post['PrinDetail'][$key]['job_name'];
	    				$adaptors->save();
	    				//$modelInven[]=$adaptors;
	    			}elseif($inv=='edit'){
	    				$adaptors = PrinDetail::findOne ( $post['PrinDetail'][$key]['id'] );
	    				$adaptors->prin_id=$prid_id;
	    				$adaptors->inventory_id=$post['PrinDetail'][$key]['inventory_id'];
	    				$adaptors->inventory_name=$post['PrinDetail'][$key]['inventory_name'];
	    				$adaptors->qty=$post['PrinDetail'][$key]['qty'];
	    				$adaptors->unit_id=$post['PrinDetail'][$key]['unit_id'];
	    				$adaptors->home_id=$post['PrinDetail'][$key]['home_id'];
	    				$adaptors->job_list_id=$post['PrinDetail'][$key]['job_list_id'];
	    				$adaptors->job_name=$post['PrinDetail'][$key]['job_name'];
	    				$adaptors->save();
	    				//$modelInven[]=$adaptors;
	    			}elseif($inv=='del'){
	    				$adaptors = PrinDetail::findOne($post['inv']['key'][$key] );
	    				$adaptors->delete ();
	    			}
	    		}
    		}
    	}
    }

    /**
     * Updates an existing Prin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelInven=$model->prinMaterial;
		$post=Yii::$app->request->post();
	
        if ($model->load($post) && $model->save()) {
        	$this->Material($model->id, $post);
        	
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelInven' => (empty($modelInven)) ? [new PrinDetail] : $modelInven,
            ]);
        }
    }
    public function actionPrToPo(){
    	$modelPoin = new Poin();
    	
    	$searchModel = new PrinDetailSearch();
    	$post=Yii::$app->request->post();
    	
    	if($post){
    	
    		if(!empty($post['selection']) && count($post['selection'])>0){
    			$postPoin['Poin']=$post['Poin'];
				
    			if ($modelPoin->load($post) ) {
    				$modelPoin->save();
    				foreach ( $post['selection'] as $val){
    					$mprinDetail = PrinDetail::findOne ( $val );
    					$mPoinDetail =new PoinDetail();
    					$mPoinDetail->poin_id=$modelPoin->id;
    					$mPoinDetail->prin_detail_id=$val;
    					$mPoinDetail->inventory_id=$mprinDetail->inventory_id;
    					$mPoinDetail->home_id=$mprinDetail->home_id;
    					$mPoinDetail->vendor_id=$mprinDetail->vendor_id;
    					$mPoinDetail->inventory_name=$mprinDetail->inventory->name;
    					$mPoinDetail->qty=$mprinDetail->qty;
    					$mPoinDetail->unit_id=$mprinDetail->unit_id;
    					$mPoinDetail->unit_name=$mprinDetail->unitBuy->name;
    					$mPoinDetail->price=$mprinDetail->inventoryPrice->price;
    					$mPoinDetail->save();
    				}

    			}
    			
    		echo '<pre>';

    		print_r($post);
    		echo '</pre>';
    		}
    		
    		
    	}
    	$get=Yii::$app->request->queryParams;
    	$get['PrinDetailSearch']['is_confirm']=1;
    	$dataProvider = $searchModel->search($get);

    	return $this->render('pr_to_po', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'modelPoin' =>$modelPoin
    	]);
    	
    
    }
    /**
     * Deletes an existing Prin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAjaxMaterial()
    {
    	$post=Yii::$app->request->post();
    	$model=new PrinDetail();
    	return $this->renderAjax ( '_form_inventory', [
    			'model' => $model,
    			'post' => $post,
    	] );

    }
    public function actionSearchUser($term)
    {
    $results = [];
    	if (Yii::$app->request->isAjax) {
    			
    	  $q = addslashes($term);

                foreach(Inventory::find()->where("(`name` like '%{$q}%')")->orderBy(['name' => SORT_ASC])->all() as $model) {
                    $results[] = [
                        'id' => $model['id'],
                        'label' => $model['name'] ,
                    	'unit_id' => $model['unit_id'] ,
                    ];
                }
   	 }

       echo Json::encode($results);

    }
public function actionVender() {
    $out = [];
    if (isset($_POST['depdrop_parents'])) {
        $parents = $_POST['depdrop_parents'];
        if ($parents != null) {
            $vender_id = $parents[0];
            
            $out = $this->getVender($vender_id);
           
            echo Json::encode(['output'=>$out, 'selected'=>'']);
            return;
            
        }
    }
    echo Json::encode(['output'=>'', 'selected'=>'']);
}
protected function getVender($id){
	$datas = InventoryPrice::find()->where(['inventory_id'=>$id])->all();
	
	$obj = [];
	if(count($datas)>0){
	foreach ($datas as $key => $value) {
		array_push($obj, ['id'=>$value->id,'name'=>'ราคา  '.$value->price.'/'.$value->inventory->unit_name.'   '.$value->vendor->company]);
	}
	}
	return $obj;
}

public function actionInventoryList($q = null, $id = null) {

	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

	$out = ['results' => ['id' => '', 'text' => '']];
	if (!is_null($q)) {
		$query = new Query();
		$query->select("id, name,unit")
		->from('psm_inventory')
		->where(['like', 'name', $q])
		->limit(20);
		$command = $query->createCommand();
		$data = $command->queryAll();
		$arrData=[];
		foreach ($data as $val){ 
			$arrData[$val['id']]['id']=$val['id'];
			$arrData[$val['id']]['text']=$val['name'].' '.$val['unit'];
		}
		//echo '<pre>';
		//print_r(array_values($arrData));
		//echo '</pre>';
		$out['results'] = array_values($arrData);
	}
	elseif ($id > 0) {
		$out['results'] = ['id' => $id, 'text' => Inventory::find($id)->name];
	}
	return $out;
}
    /**
     * Finds the Prin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Prin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Prin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionChangVendor(){
    	$model = InventoryPrice::findOne($_POST['PrinDetail']['inventory_price_id']);
    	$_POST['PrinDetail']['vendor_id']=$model->vendor_id;
    	$_POST['PrinDetail']['unit_buy_id']=$model->inventory->unit_id;
    	//$_POST['PrinDetail']['price']=$model->price;
    	$_POST['PrinDetail']['unit_name']=$model->inventory->unit_name;
    
    	$modelPrinDet = PrinDetail::findOne($_POST['prin_detail_id']);
    	if ($modelPrinDet->load($_POST) && $modelPrinDet->save()) {
    		return $this->redirect([$_POST['mainView']]);
    	}
    }


}

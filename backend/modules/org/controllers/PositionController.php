<?php

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgJobOption;
use Yii;
use backend\modules\org\models\OrgPosition;
use backend\modules\org\models\OrgPositionSearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\org\models\OrgPositionProperty;
use yii\filters\AccessControl;

/**
 * PositionController implements the CRUD actions for OrgPosition model.
 */
class PositionController extends Controller
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
              'access' => [
                    'class' => AccessControl::className(),
                     'rules' => [
                        ['allow' => true,
                            'roles' => ['@'],
                            'matchCallback' => function ($rule, $action) {
                                $module = Yii::$app->controller->module->id;
                                $action = Yii::$app->controller->action->id;
                                $controller = Yii::$app->controller->id;
                                $route = "/$module/$controller/$action";
                                if (Yii::$app->user->can($route)) {
                                    return true;
                                }
                            }
                        ]
                     ]
           ]
        ];
    }

    /**
     * Lists all OrgPosition models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrgPositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OrgPosition model.
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
     * Creates a new OrgPosition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrgPosition();
        if ($model->load(Yii::$app->request->post())) {
            //Property
            $dataProp = Yii::$app->request->post('dataProp');
            //Responsibility
            $dataRes = Yii::$app->request->post('dataRes');
             $valid = $model->validate();
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save()) {
                        //property
            			$this->JobProperty($model->id);
                      //responsibility
                   		 $this->JobResponsibility($model->id);
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    return ($e->getMessage());
                    $transaction->rollBack();
                }
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            		'modelsProp' => [],
            		'modelsRes' => [],
            ]);
        }
    }

    /**
     * Updates an existing OrgPosition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsRes = $model->responsibilities;
        $modelsProp = $model->properties;
        if ($model->load(Yii::$app->request->post())) {
            $valid = $model->validate();
            //Property
            $oldPropIDs = !empty($modelsProp) ? ArrayHelper::map($modelsProp, 'option_id', 'option_id') : [];
            //Responsibility
          
            $oldResIDs = !empty($modelsRes) ? ArrayHelper::map($modelsRes, 'option_id', 'option_id') : [];
            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save()) {
                    	$this->JobProperty($id,$oldPropIDs);
                    	$this->JobResponsibility($id,$oldResIDs);                      
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    return ($e->getMessage());
                    $transaction->rollBack();
                }
            }


        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsProp' =>  $modelsProp,
                'modelsRes' =>  $modelsRes,
            ]);
        }
    }
    private  function JobResponsibility($position_id,$oldResIDs=[]){
    	$dataRes = Yii::$app->request->post('dataRes');
    	$res_check = Yii::$app->request->post('res-check');
    	if(count($res_check)>0){
    		$row=1;
    		foreach ($dataRes['option_id'] as $key_n =>$val_n){
    			$dataRes['seq'][$key_n]=$row;
    			$row++;
    		}
    		$seq_p=1;
    		foreach ($res_check as $key_pos=> $val_pos){
    			if($val_pos!='del' && $val_pos!='add'){
    				$pos_id = $dataRes['option_id'][$key_pos];
    				$title = $dataRes['title'][$key_pos];
    			}
    			if($val_pos=='add'){
    				$modelProp = new OrgJobOption();
    				$modelProp->_type = OrgJobOption::TYPE_RESPONSIBILITY;
    				$modelProp->title = $dataRes['title'][$key_pos];
    				$modelProp->save();
    				$pos_id=$modelProp->id;
    				$modelProperty =new OrgPositionProperty();
    				$modelProperty->option_id=$pos_id;
    				$modelProperty->position_id=$position_id;
    				$modelProperty->sorter=$dataRes['seq'][$key_pos];
    				$modelProperty->save();
    	
    			}elseif($val_pos=='property'&& empty($oldResIDs[$pos_id])   ){
    				$modelProperty =new OrgPositionProperty();
    				$modelProperty->option_id=$pos_id;
    				$modelProperty->position_id=$position_id;
    				$modelProperty->sorter=$dataRes['seq'][$key_pos];
    				$modelProperty->save();
    				$oldResIDs[$pos_id]=$pos_id;
    			}elseif($val_pos=='edit'){
    	
    				$modelProperty = OrgPositionProperty::findOne($pos_id);
    				$modelProperty->sorter=$dataRes['seq'][$key_pos];
    				$modelProperty->save();
    	
    			}elseif($val_pos=='del'){
    				OrgPositionProperty::deleteAll(['option_id' =>  $dataRes['old_id'][$key_pos], 'position_id' => $id]);
    			}
    			$seq_p++;
    		}
    	
    	}
    }
    private  function JobProperty($position_id,$oldPropIDs=[]){
    	$dataProp = Yii::$app->request->post('dataProp');
    	$pos_check = Yii::$app->request->post('pos-check');
    	if(count($pos_check)>0){
    		$row=1;
    		foreach ($dataProp['option_id'] as $key_n =>$val_n){
    			$dataProp['seq'][$key_n]=$row;
    			$row++;
    		}
    		 
    		$seq_p=1;
    	
    		foreach ($pos_check as $key_pos=> $val_pos){
    			if($val_pos!='del' && $val_pos!='add'){
    				$pos_id = $dataProp['option_id'][$key_pos];
    				$title = $dataProp['title'][$key_pos];
    			}
    			if($val_pos=='add'){
    				 
    				$modelProp = new OrgJobOption();
    				$modelProp->_type = OrgJobOption::TYPE_PROPERTY;
    				$modelProp->title = $dataProp['title'][$key_pos];
    				$modelProp->save();
    				$pos_id=$modelProp->id;
    				$modelProperty =new OrgPositionProperty();
    				$modelProperty->option_id=$pos_id;
    				$modelProperty->position_id=$position_id;
    				$modelProperty->sorter=$dataProp['seq'][$key_pos];
    				$modelProperty->save();
    	
    			}elseif($val_pos=='property'&& empty($oldPropIDs[$pos_id])   ){
    				$modelProperty =new OrgPositionProperty();
    				$modelProperty->option_id=$pos_id;
    				$modelProperty->position_id=$position_id;
    				$modelProperty->sorter=$dataProp['seq'][$key_pos];
    				$modelProperty->save();
    				$oldPropIDs[$pos_id]=$pos_id;
    			}elseif($val_pos=='edit'){
    	
    				$modelProperty = OrgPositionProperty::findOne($pos_id);
    				$modelProperty->sorter=$dataProp['seq'][$key_pos];
    				$modelProperty->save();
    	
    			}elseif($val_pos=='del'){
    				OrgPositionProperty::deleteAll(['option_id' =>  $dataProp['old_id'][$key_pos], 'position_id' => $position_id]);
    			}
    			$seq_p++;
    		}
    	
    	}
    }

    /**
     * Deletes an existing OrgPosition model.
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
     * Finds the OrgPosition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return OrgPosition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OrgPosition::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

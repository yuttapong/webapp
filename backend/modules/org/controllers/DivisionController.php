<?php
namespace backend\modules\org\controllers;
use Yii;
use backend\modules\org\models\OrgDivision;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\org\models\OrgPart;
use backend\modules\org\models\OrgDepartment;
use backend\modules\org\models\OrgDepartmentSearch;
use yii\filters\AccessControl;

/**
 * DivisionController implements the CRUD actions for orgDivision model.
 */
class DivisionController extends Controller
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
     * Lists all orgDivision models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => orgDivision::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single orgDivision model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModelDivision($id),
        ]);
    }


    /**
     * Creates a new orgDivision model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new orgDivision();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing orgDivision model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelDivision($id);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing orgDivision model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModelDivision($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the orgDivision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return orgDivision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelDivision($id)
    {
        if (($model = orgDivision::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /************************************************
     * Part ::  ส่วนงาน
     ***********************************************/


    /**
     * @param string $division_id
     * @return string
     */
    public function actionParts($division_id = '')
    {

        $query = orgPart::find();
        if (isset($division_id) && !empty($division_id)) {
            $query->where(['division_id' => $division_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('/part/index', [
            'dataProvider' => $dataProvider,
            'modelDivision' => OrgDivision::findOne($division_id)
        ]);
    }

    /**
     * Displays a single orgPart model.
     * @param integer $id
     * @return mixed
     */
    public function actionPart($id)
    {
        return $this->render('/part/view', [
            'model' => $this->findModelPart($id),
        ]);
    }

    /**
     * Creates a new orgPart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatePart($division_id = '')
    {
        $model = new orgPart();
        if (!empty($division_id)) {
            $model->division_id = $division_id;
            $modelDivision = OrgDivision::findOne($division_id);
        } else {
            $modelDivision = [];
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['part', 'id' => $model->id,'division_id'=>$model->division_id]);
        } else {
            return $this->render('/part/create', [
                'model' => $model,
                'modelDivision' => $modelDivision
            ]);
        }
    }

    /**
     * Updates an existing orgPart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatePart($id)
    {
        $model = $this->findModelPart($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['parts', 'division_id'=>$model->division_id]);
        } else {
            return $this->render('/part/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing orgPart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeletePart($id)
    {
         $this->findModelPart($id)->delete();

        return $this->redirect(['parts']);
    }

    /**
     * Finds the orgDivision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return orgDivision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelPart($id)
    {
        if (($model = OrgPart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



    /************************************************
     * Department ::  แผนก
     ***********************************************/


    /**
     * Lists all orgDepartment models.
     * @return mixed
     */
    public function actionDepartments($part_id = '')
    {
        $searchModel = new OrgDepartmentSearch(['part_id' => $part_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/department/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single orgDepartment model.
     * @param string $id
     * @return mixed
     */
    public function actionDepartment($id)
    {
        return $this->render('/department/view', [
            'model' => $this->findModelDepartment($id),
        ]);
    }

    /**
     * Creates a new orgDepartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateDepartment($part_id='')
    {
        $model = new orgDepartment();

        if(!empty($part_id)){
            $modelPart =OrgPart::findOne(['id'=>$part_id]);
            $model->part_id = $modelPart->id;
            $model->division_id = $modelPart->division_id;

        }else{
            $modelPart = [];
        }




        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['departments',
                'division_id' => $model->division_id,
                'part_id' => $model->part_id
            ]);
        } else {
            return $this->render('/department/create', [
                'model' => $model,
                'modelPart' => $modelPart,
            ]);
        }
    }

    /**
     * Updates an existing orgDepartment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdateDepartment($id)
    {
        $model = $this->findModelDepartment($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['departments', 'part_id' => $model->part_id]);
        } else {
            return $this->render('/department/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing orgDepartment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDeleteDepartment($id)
    {
         $model = $this->findModelDepartment($id)->delete();

        return $this->redirect(['departments','part_id'=>$model->part_id]);
    }



    /**
     * Finds the orgDivision model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return orgDivision the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelDepartment($id)
    {
        if (($model = OrgDepartment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


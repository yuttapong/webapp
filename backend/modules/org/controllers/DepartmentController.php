<?php

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgDepartmentSearch;
use backend\modules\org\models\OrgPart;
use Yii;
use backend\modules\org\models\orgDepartment;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * DepartmentController implements the CRUD actions for orgDepartment model.
 */
class DepartmentController extends Controller
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
     * Lists all orgDepartment models.
     * @return mixed
     */
    public function actionIndex($part_id='')
    {
        $searchModel = new OrgDepartmentSearch(['part_id'=>$part_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single orgDepartment model.
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
     * Creates a new orgDepartment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($part_id='')
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
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('create', [
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->code]);
        } else {
            return $this->render('update', [
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the orgDepartment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return orgDepartment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = orgDepartment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

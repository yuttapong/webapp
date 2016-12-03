<?php

namespace backend\modules\setting\controllers;

use Yii;
use common\models\SysBasicData;
use backend\modules\setting\models\SysBasicDataSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\SysTable;
use yii\filters\AccessControl;

/**
 * SysBasicDataController implements the CRUD actions for SysBasicData model.
 */
class SysBasicDataController extends Controller

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
     * Lists all SysBasicData models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysBasicDataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysBasicData model.
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
     * Creates a new SysBasicData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysBasicData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'table_id'=>$model->table_id]);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    /**
     * Updates an existing SysBasicData model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $sysTable = new SysTable();
        $group = SysTable::findOne($model->table_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'SysBasicDataSearch[table_id]'=> $model->table_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'group' => $group
            ]);
        }
    }

    /**
     * Deletes an existing SysBasicData model.
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
     * Finds the SysBasicData model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SysBasicData the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysBasicData::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

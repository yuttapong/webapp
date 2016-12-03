<?php

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgDivision;
use Yii;
use backend\modules\org\models\orgPart;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrgPartController implements the CRUD actions for orgPart model.
 */
class PartController extends Controller
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
     * Lists all orgPart models.
     * @return mixed
     */
    public function actionPartIndex($division_id='')
    {

        $query = orgPart::find();
        if(isset($division_id) && !empty($division_id)){
            $query->where(['division_id'=>$division_id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' =>$query
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'modelDivision' => OrgDivision::findOne($division_id)
        ]);
    }

    /**
     * Displays a single orgPart model.
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
     * Creates a new orgPart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($division_id='')
    {
        $model = new orgPart();
        if(!empty($division_id)){
            $model->division_id = $division_id;
            $modelDivision = OrgDivision::findOne($division_id);
        }else{
            $modelDivision = [];
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
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
     * Deletes an existing orgPart model.
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
     * Finds the orgPart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return orgPart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = orgPart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

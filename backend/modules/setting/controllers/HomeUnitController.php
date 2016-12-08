<?php

namespace backend\modules\setting\controllers;


use backend\modules\setting\models\CustomerSearch;
use Yii;
use common\models\Home;
use backend\modules\setting\models\HomeUnitSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * HomeUnitController implements the CRUD actions for home model.
 */
class HomeUnitController extends Controller
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
     * Lists all home models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HomeUnitSearch(['status'=>Home::STATUS_ACTIVE]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single home model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $model = $this->findModel($id);
         if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', [
                'model' => $model
            ]);
        } else {
            return $this->render('view', [
                'model' => $model
            ]);
        }
    }

    /**
     * Creates a new home model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Home();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } elseif(Yii::$app->request->isAjax) {
            return $this->renderPartial('create', [
                'model' => $model,
            ]);
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing home model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $searchModelCustomer = new CustomerSearch();
        $dataProviderCustomer = $searchModelCustomer->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'dataProviderCustomer' => $dataProviderCustomer,
                'searchModelCustomer' => $searchModelCustomer,
            ]);
        }
    }

    /**
     * Deletes an existing home model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $home = $this->findModel($id);
        $home->status = Home::STATUS_DELETED;
        $home->save();

        return $this->redirect(['index']);
    }


    public function actionModelSearchCustomer(){
        if(Yii::$app->request->isAjax) {
            $searchModelCustomer = new CustomerSearch();
            $dataProviderCustomer = $searchModelCustomer->search(Yii::$app->request->queryParams);
            return $this->renderPartial('modal/find-customer', [
                'dataProviderCustomer' => $dataProviderCustomer,
                'searchModelCustomer' => $searchModelCustomer,
            ]);
        }else{
            $searchModelCustomer = new CustomerSearch();
            $dataProviderCustomer = $searchModelCustomer->search(Yii::$app->request->queryParams);
            return $this->renderPartial('modal/find-customer', [
                'dataProviderCustomer' => $dataProviderCustomer,
                'searchModelCustomer' => $searchModelCustomer,
            ]);
        }
    }



    /**
     * Finds the home model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return home the loaded model
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


    /**
     * action to fetch customer
     */
    public function actionCustomerList($q = null) {
        $customers = Customer::find()
            ->filterWhere(['like', 'firstname', $q])
            ->all();
        $out = [];
        foreach ($customers as $d) {
            $out[] = [
                'id' => $d->id,
                'value' => $d->fullname,
                'name'=>$d->id.' - ' .$d->fullname
            ];
        }
        echo Json::encode($out);
    }
}

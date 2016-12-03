<?php

namespace backend\modules\recruitment\controllers;

use backend\modules\recruitment\models\RcmAppJobOption;
use Yii;
use backend\modules\recruitment\models\RcmSetting;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;

/**
 * SettingController implements the CRUD actions for RcmSetting model.
 */
class SettingController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /*
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'edittitle' => [                                   // identifier for your editable column action
                'class' => EditableColumnAction::className(),  // action class name
                'modelClass' => RcmAppJobOption::className(),  // the model for the record being edited
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;  // return any custom output value if desired
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return '';                                  // any custom error to return after model save
                },
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => ''],              // error summary HTML options
                'postOnly' => true,
                'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }
    */


    /**
     * Lists all RcmSetting models.
     * @return mixed
     */
    public function actionGeneral()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RcmSetting::find(),
        ]);


        // save general setting
        if (Yii::$app->request->isAjax) {
            $result = ['msg'=>'empty'];
            $settings = $_POST['settings'];
            $err = 0;
            if (!empty($settings)) {
               // foreach ($settings as $setting) {
                    foreach ($settings as $name => $value) {
                        $model = RcmSetting::findOne(['name' => $name,'type'=>RcmSetting::TYPE_REQUESION]);
                        $model->value = $value;
                        if ($model->save()) {
                            $err = 0;
                        } else {
                            $err++;
                        }
                        if ($err == 0) {
                            $result = ['status' => 'success'];
                        } else {
                            $result = ['status' => 'error'];
                        }

                    }
               // }

            }
            echo Json::encode($result);
        } else {
            return $this->render('general', [
                'dataProvider' => $dataProvider,
                'models' => RcmSetting::find()->all(),
            ]);
        }


    }


    /**
     * Displays a single RcmSetting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new RcmSetting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RcmSetting;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RcmSetting model.
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
     * Deletes an existing RcmSetting model.
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
     * Finds the RcmSetting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RcmSetting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RcmSetting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


    public function actionResponsibilities()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RcmAppJobOption::find()
                ->where(['_type' => RcmAppJobOption::TYPE_RESPONSIBILITY]),
        ]);
        return $this->render('responsibilities', [
            'dataProvider' => $dataProvider,

        ]);
    }


    public function actionProperties()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => RcmAppJobOption::find()
                ->where(['_type' => RcmAppJobOption::TYPE_PROPERTY]),
        ]);

        return $this->render('properties', [
            'dataProvider' => $dataProvider,
        ]);
    }


}

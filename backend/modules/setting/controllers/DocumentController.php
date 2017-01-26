<?php

namespace backend\modules\setting\controllers;

use backend\modules\setting\models\DocumentSearch;
use common\models\SysDocument;
use common\models\SysDocumentOption;
use common\models\SysDocumentPersonnel;
use common\models\SysDocumentPosition;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DocumentController implements the CRUD actions for SysDocument model.
 */
class DocumentController extends Controller
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
     * Lists all SysDocument models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysDocument model.
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
     * Creates a new SysDocument model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysDocument();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->document_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SysDocument model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->document_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Deletes an existing SysDocument model.
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
     * Finds the SysDocument model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SysDocument the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysDocument::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * ตั้งค่าอนุมัติ
     * @param $id
     * @return string
     */
    public function actionConfig($id)
    {
        $modelsDocument = $this->findModel($id);
        $modelsPosition = $modelsDocument->documentPosition;
        $modelsPersonnel = [];

        if (!empty($modelsPosition)) {
            foreach ($modelsPosition as $indexPosition => $modelPosition) {
                $rooms = $modelPosition->documentPersonnels;
                $modelsPersonnel[$indexPosition] = $rooms;
            }
        }

        if (!empty($_POST)) {

            foreach ($_POST['SysDocumentOption'] as $key => $val) {
                $model = SysDocumentOption::findOne($val['_id']);
                $model->seq = $val['seq'];
                $model->_type = $val['_type'];
                $model->active = $val['active'];
                if ($val['_type'] == 'Organization') {
                    $model->data = serialize(['level' => $val['level']]);
                    $model->save();
                } elseif ($val['_type'] == 'Position') {
                    $model->data = serialize($val['position']);
                    $model->save();

                } elseif ($val['_type'] == 'Custom') {
                    $model->save();

                }


            }
        }


        return $this->render('site', [
                'modelsDocument' => $modelsDocument,
                'modelPos' => (empty($modelsPosition)) ? [new SysDocumentPosition] : $modelsPosition,
                'modelPersonnel' => (empty($modelsPersonnel)) ? [[new SysDocumentPersonnel]] : $modelsPersonnel
            ]
        );
    }

    public function actionConfig1($id)
    {
        $modelDoc = $this->findModel($id);
        $modelsPosition = $modelDoc->documentPosition;
        $modelsPersonnel = [];

        if (!empty($modelsPosition)) {
            foreach ($modelsPosition as $indexPosition => $modelPosition) {
                $rooms = $modelPosition->documentPersonnels;
                $modelsPersonnel[$indexPosition] = $rooms;
            }
        }


        return $this->render('_form_position', [
            'model' => $modelDoc,
            'modelPos' => (empty($modelsPosition)) ? [new SysDocumentPosition] : $modelsPosition,
            'modelPersonnel' => (empty($modelsPersonnel)) ? [[new SysDocumentPersonnel]] : $modelsPersonnel
        ]);
    }

    public function actionPosition($id)
    {
        //echo  '<pre>';
        //print_r($_POST);
        //echo  '</pre>';
        $modelDoc = $this->findModel($id);
        $modelsPosition = $modelDoc->documentPosition;
        $modelsPersonnel = [];

        if (!empty($modelsPosition)) {
            foreach ($modelsPosition as $indexPosition => $modelPosition) {
                $rooms = $modelPosition->documentPersonnels;
                $modelsPersonnel[$indexPosition] = $rooms;
            }
        }


        return $this->render('CopyOf_form_position', [
            'model' => $modelDoc,
            'modelPos' => (empty($modelsPosition)) ? [new SysDocumentPosition] : $modelsPosition,
            'modelPersonnel' => (empty($modelsPersonnel)) ? [[new SysDocumentPersonnel]] : $modelsPersonnel
        ]);
    }
}

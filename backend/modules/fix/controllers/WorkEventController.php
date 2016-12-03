<?php

namespace backend\modules\fix\controllers;

use Yii;
use backend\modules\fix\models\WorkEvent;
use backend\modules\fix\models\WorkEventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WorkEventController implements the CRUD actions for WorkEvent model.
 */
class WorkEventController extends Controller
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
     * Lists all WorkEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WorkEvent model.
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
     * Creates a new WorkEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WorkEvent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WorkEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->start_date = date("d-m-Y H:i", $model->start_date);
        if ($model->end_date != '') {
            $model->end_date = date("d-m-Y H:i", $model->end_date);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing WorkEvent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->is_delete = 1;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WorkEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WorkEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WorkEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionShow()
    {
        $searchModel = new WorkEventSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);


        return $this->render('show', ['events' => 1,
        ]);

    }

    public function actionJsoncalendar($id = 1, $start = NULL, $end = NULL, $_ = NULL)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $events = WorkEvent::find()
            ->where(['between', 'start_date', strtotime($start), strtotime($end)])
            ->all();
        $tasks = [];
        $i = 1;
        foreach ($events as $eve) {
            $event = new \yii2fullcalendar\models\Event();
            $event->id = $eve->id;
            $event->title = $eve->title;
            $event->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            $event->start = date('Y-m-d\TH:i:s\Z', $eve->start_date);
            if ($eve->end_date != '') {
                $event->end = date('Y-m-d\TH:i:s\Z', $eve->end_date);
                $i++;
            }
            //$event->end = $eve->ngayKetThuc.' '.$eve->gioKetThuc;
            $tasks[] = $event;
        }
        return $tasks;
    }
}

<?php

namespace backend\modules\setting\controllers;

use common\models\SysBasicData;
use Yii;
use common\models\SysTable;
use backend\modules\setting\models\SysTableSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use backend\models\Model;
use yii\filters\AccessControl;
/**
 * SysTableController implements the CRUD actions for SysTable model.
 */
class SysTableController extends Controller
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
     * Lists all SysTable models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysTableSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysTable model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SysBasicData::find()->where(['table_id' => $id])->orderBy('sorter'),
            'pagination' => [
                'pageSize' => 20,
            ],

        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the SysTable model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SysTable the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysTable::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new SysBasicData model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateData($table_id)
    {
        $model = new SysBasicData();
        $sysTable = SysTable::findOne($table_id);
        $model->create_at = mktime();
        $model->create_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $table_id]);
        } else {
            return $this->render('_formsub', [
                'model' => $model,
                'sysTable' => $sysTable,
            ]);
        }
    }


    /**
     * Creates a new SysTable model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysTable();
        $modelsItem = [new SysBasicData];


        if ($model->load(Yii::$app->request->post())) {
            $modelsItem = Model::createMultiple(SysBasicData::className());
            Model::loadMultiple($modelsItem, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsItem) && $valid;


            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        $sorter = 1;
                        foreach ($modelsItem as $modelItem) {
                            $modelItem->table_id = $model->id;
                            $modelItem->sorter = $sorter;

                            if (!($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $sorter++;
                        }

                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    return $e->getMessage();
                }


            }

        } else {

            return $this->render('create', [
                'model' => $model,
                'modelsItem' => (empty($modelsItem) ? [new SysBasicData] : $modelsItem),
            ]);
        }

    }

    /**
     * Updates an existing SysTable model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelsItem = SysBasicData::find()->where(['table_id' => $model->id])->all();

        if ($model->load(Yii::$app->request->post())) {
            $itemOldIDs = ArrayHelper::map($modelsItem, 'id', 'id');
            $modelsItem = Model::createMultiple(SysBasicData::className(), $modelsItem);
            Model::loadMultiple($modelsItem, Yii::$app->request->post());
            $itemDeletedIDs = array_diff($itemOldIDs, array_filter(ArrayHelper::map($modelsItem, 'id', 'id')));

            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsItem) && $valid;


            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($itemDeletedIDs)) {
                            $flag = SysBasicData::deleteAll(['id' => $itemDeletedIDs]);
                        }
                        $sorter = 1;
                        foreach ($modelsItem as $modelItem) {
                            $modelItem->table_id = $model->id;
                            $modelItem->sorter = $sorter;

                            if (!($flag = $modelItem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $sorter++;
                        }

                    }
                    if ($flag) {

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    return $e->getMessage();
                }


            }

        } else {
            return $this->render('update', [
                'model' => $model,
                'modelsItem' => (empty($modelsItem) ? [new SysBasicData] : $modelsItem),
            ]);
        }
    }

    /**
     * Deletes an existing SysTable model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}

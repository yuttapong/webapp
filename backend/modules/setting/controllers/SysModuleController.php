<?php

namespace backend\modules\setting\controllers;

use common\models\SysMenu;
use Yii;
use common\models\SysModule;
use backend\modules\setting\models\SysModuleSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use backend\models\Model;
use yii\filters\AccessControl;
/**
 * SysModuleController implements the CRUD actions for SysModule model.
 */
class SysModuleController extends Controller
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

    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editModule' => [                                       // identifier for your editable column action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => SysModule::className(),                // the model for the record being edited
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;      // return any custom output value if desired
                },
                'outputMessage' => function ($model, $attribute, $key, $index) {
                    return '';                                  // any custom error to return after model save
                },
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => ''],              // error summary HTML options
                'postOnly' => true,
                // 'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }

    /**
     * Lists all SysModule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SysModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SysModule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);
    }

    /**
     * Creates a new SysModule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SysModule();
        $modelsMenu = [new SysMenu];

        if ($model->load(Yii::$app->request->post())) {

            $modelsMenu = Model::createMultiple(SysMenu::classname());
            Model::loadMultiple($modelsMenu, Yii::$app->request->post());

            // ajax validation

            if (Yii::$app->request->isAjax) {

                Yii::$app->response->format = Response::FORMAT_JSON;

                return ArrayHelper::merge(

                    ActiveForm::validateMultiple($model),

                    ActiveForm::validate($modelsMenu)

                );

            }


            // validate all models
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsMenu) && $valid;


            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {

                        if( ! empty($modelsMenu)){
                            foreach ($modelsMenu as $modelMenu) {
                                $modelMenu->module_id = $model->id;
                                if (($flag = $modelMenu->save(false)) === false) {
                                    $transaction->rollBack();
                                    break;
                                }

                            }
                        }


                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }


                } catch (Exception $e) {
                    $transaction->rollBack();

                }

            }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelsMenu' => (empty($modelsMenu) ? [new SysMenu] : $modelsMenu),
            ]);
        }
    }

    /**
     * Updates an existing SysModule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsMenu = SysMenu::find()
            ->where(['module_id'=>$model->id])
            ->orderBy(['parent'=>SORT_ASC,'order'=>SORT_ASC])
            ->all();

        if ($model->load(Yii::$app->request->post())) {
            $menuOldIDs = ArrayHelper::map($modelsMenu,'id','id');
            $modelsMenu = Model::createMultiple(SysMenu::className(),$modelsMenu);
            Model::loadMultiple($modelsMenu, Yii::$app->request->post());
            $menuDeletedIDs = array_diff($menuOldIDs,array_filter(ArrayHelper::map($modelsMenu,'id','id')));



            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsMenu) && $valid;


            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {

                    if ($flag = $model->save(false)) {

                        if (!empty($menuDeletedIDs)) {
                            $flag = SysMenu::deleteAll(['id' => $menuDeletedIDs]);
                        }

                        $sortMenu = 1;
                        foreach ($modelsMenu as $menu) {
                            $menu->module_id = $model->id;
                            $menu->order = $sortMenu;

                            if ( !($flag = $menu->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                            $sortMenu++;
                        }

                    }
                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'บันทึกข้อมูลสำเร็จ');
                        return $this->redirect(['update', 'id' => $model->id]);
                    }

                } catch (Exception $e) {
                    $transaction->rollBack();
                    return $e->getMessage();
                }


            }

        }
            return $this->render('update', [
                'model' => $model,
                'modelsMenu' => (empty($modelsMenu) ? [new SysMenu] : $modelsMenu),
            ]);

    }

    /**
     * Deletes an existing SysModule model.
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
     * Finds the SysModule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SysModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SysModule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}

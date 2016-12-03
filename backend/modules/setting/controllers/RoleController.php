<?php

namespace backend\modules\setting\controllers;

use common\models\AuthUserModule;
use common\models\SysModule;
use Yii;
use backend\modules\setting\models\User;
use backend\modules\setting\models\UserSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RoleController implements the CRUD actions for User model.
 */
class RoleController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $userModule = ArrayHelper::map(AuthUserModule::find()->where(['user_id' => $id])->all(), 'module_id', 'module_id');
        $modules = SysModule::find()->where(['active' => 1])->all();
        $moduleItems = ArrayHelper::map($modules, 'id', 'name_th');

        return $this->render('view', [
            'model' => $this->findModel($id),
            'userModule' => $userModule,
            'modules' => $modules,
            'moduleItems' => $moduleItems,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $modules = SysModule::find()->where(['active' => 1])->all();
        $moduleItems = ArrayHelper::map($modules, 'id', 'name_th');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'userModule' => [],
                'modules' => $modules,
                'moduleItems' => $moduleItems,
                'allRoles' => $this->getAllRoles(),
            ]);
        }
    }

    public function getAllRoles()
    {
        $auth = $auth = Yii::$app->authManager;
        return ArrayHelper::map($auth->getRoles(), 'name', 'name');
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userModule = ArrayHelper::map(AuthUserModule::find()->where(['user_id' => $id])->all(), 'module_id', 'module_id');
        $modules = SysModule::find()->where(['active' => 1])->all();
        $moduleItems = ArrayHelper::map($modules, 'id', 'name_th');

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                AuthUserModule::deleteAll(['user_id' => $model->id]);
                $selectedModules = isset($_POST['module']) ? $_POST['module'] : [];
                if (!empty($selectedModules)) {
                    foreach ($selectedModules as $m) {
                        $insertModule = new  AuthUserModule();
                        $insertModule->user_id = $model->id;
                        $insertModule->module_id = $m;
                        $insertModule->save();
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
            'userModule' => $userModule,
            'modules' => $modules,
            'moduleItems' => $moduleItems,
            'roles' => $this->getAllRoles(),
        ]);

    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use common\models\AuthRight;
use common\models\SysModule;
use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;

/**
 * ManageUserController implements the CRUD actions for User model.
 */
class ManageUserController extends Controller
{
    public function init()
    {
        $auth = Yii::$app->authManager;

        //echo Yii::$app->authManager->checkAccess(2, 'user-edit');

    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(), //yii\filters\AccessControl
                //'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'update', 'delete', 'role', 'load-right', 'fetch-tab'],
                        'roles' => ['ManageUser'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'roles' => ['userView'],
                        'allow' => true
                    ]
                    ,
                    [
                        'actions' => ['create'],
                        'roles' => ['userAdd'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['delete'],
                        'roles' => ['userDel'],
                        'allow' => true
                    ],
                    [
                        'actions' => ['update'],
                        'roles' => ['userEdit'],
                    ]

                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
        $model->created_at = mktime();
        $model->created_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->setPassword($model->password);
            $model->generateAuthKey();
            if ($model->save()) {
                $model->assignment();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
        $model->getRoleByUser();
        $model->password = $model->password_hash;
        $model->confirm_password = $model->password_hash;
        $oldPass = $model->password_hash;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($oldPass !== $model->password) {
                $model->setPassword($model->password);
            }
            if ($model->save()) {
                $model->assignment();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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
     *  manage role of user
     */
    public function actionRole($id)
    {
        $modules = SysModule::find()->all();
        $model = $this->findModel($id);
        $itemsTab = [];
        foreach ($modules as $module) {
            $itemsTab[] = [
                'headerOptions' => [],
                'label' => '<div style=""><i class="glyphicon glyphicon-home"></i> ' . $module->name_th . '</div>',
                //'content' => "content".$module->_id,
                'linkOptions' => [
                    'data-url' => Url::to(['/manage-user/fetch-tab?module_id=' . $module->_id]),
                ],
                'pluginOptions' => [
                    'enableCache' => false,
                ]
            ];
        }


        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                // $model->assignment();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('role', [
                'model' => $model,
                'modules' => $modules,
                'itemsTab' => $itemsTab,
            ]);
        }
    }

    public function actionLoadRight($module_id)
    {
        $module_id = Yii::$app->request->get('module_id');
        $auth_right = AuthRight::find()->where(['module_id' => $module_id])->all();
        return $this->renderAjax("_auth_right", ['auth_right' => $auth_right], true);
    }

    public function actionFetchTab()
    {
        $module_id = Yii::$app->request->get('module_id');
        $auth_right = AuthRight::getMenuRights($module_id);
        $html = $this->renderPartial("_auth_right", ['auth_right' => $auth_right], true);
        return Json::encode($html);
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

<?php
namespace backend\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\org\models\OrgStructureItem;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use common\models\Blog;
use common\models\SysModule;


/**
 * Site controller
 */
class SiteController extends Controller
{

    public $layout = 'main-full';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','request-password-reset','reset-password','orgchart'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {

        // $this->sidebarItems = [];

        //$module_category = SysModule::getListModuleForWidget();
        $module_category = SysModule::getItemModuleForButtonApp();
        $blogs = Blog::find()->all();

        return $this->render('index', [
            'module_category' => $module_category,
            'blogs' => $blogs,
            'sidebarItems' => "noom"
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // $user = User::findOne(Yii::$app->user->id);
            // $user->logged_in_ip = Yii::app()->request->getUserHostAddress;
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'โปรดเช็คอีเมลของคุณ เพื่อทำรายการต่อไป.');

                return $this->redirect(['request-password-reset']);
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'เปลี่่ยนรหัสผ่านใหม่เรียบร้อยแล้ว.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionOrgchart(){
        $charts = $this->getGoJsChart();
        return $this->render('orgchart', [
            'charts' => $charts
        ]);
    }

    private function getGoJsChart()
    {
        $models = OrgStructureItem::find()->all();
        $items = [];
        if ($models) {
            foreach ($models as $m) {
                $name = $m->name?explode("-",$m->name):array();
                $person = OrgPersonnel::findOne($m->id);
                $photo = $person->photo? $person->getPhotoThumbnailLink():null;
                $items[] = [
                    'key' => $m->id,
                    'parent' => $m->parent_id,
                    'title' => $name[0],
                    'postionId' => $m->position_id,
                    'name' => $m->first_name,
                    'photo' => $photo,
                    // 'headOf' => $name[0],
                ];
            };
        }
        $array = [
            'class' => 'go.TreeModel',
            'nodeDataArray' => $items,
        ];
        return  json_encode($array);
    }
}

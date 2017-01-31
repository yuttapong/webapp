<?php
namespace backend\controllers;

use backend\models\ScBemployee;
use common\models\User;
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
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password'],
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
                    'logout' => ['get'],
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
        $module_category = SysModule::getListModuleForWidget();
        $blogs = Blog::find()->all();
        return $this->render('index', [
            'module_category' => $module_category,
            'menuItems' => SysModule::getItemModuleForButtonApp(),
            'blogs' => $blogs,
            'sidebarItems' => "noom"
        ]);
    }

    public function actionLogin()
    {

        Yii::$app->user->logout();

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // $user = User::findOne(Yii::$app->user->id);
            // $user->logged_in_ip = Yii::app()->request->getUserHostAddress;
            $this->registerSessionSc();
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * ทำให้ระบบเก่าใช้งาน Session ได้หลังจาก login ระบบนี้
     */
    private  function registerSessionSc() {
        $user = User::findOne(Yii::$app->user->id);
        $name = $user->personnel->fullnameTH;
        $bemployee = ScBemployee::find()->where(['EMPID' => $user->username])->one();

        //username
        $_SESSION['USERNAME'] = $user->username;
        $_SESSION["activeloginadmin"] = $user->username;
        $_SESSION["m_dmpid"] = $bemployee->DEPTID;//รหัสแผนก ใช้นะระบบ inventory ต่าง ๆ
        $_SESSION["sc_emp_status"] = $bemployee->EMP_STATUS;//สถานะ
        $_SESSION['sc_name'] = $name;//ชื่อสกุล

        //ตัวแปรเก็บข้อมูลโปรโฟล์ user ตอนนี้ใช้ที่ระบบ cheque center นะ
        $_SESSION['sc_user_profile'] = array(
            'emp_id' => $bemployee->EMPID,
            'firstname' => $bemployee->EMPFNAME,
            'lastname' => $bemployee->EMPLNAME,
            'name' => $name,
            'nickname' => $bemployee->NickName
        );

    }

    /**
     *  Clear Session System Center
     */
    private function clearSessionSc() {
        unset( $_SESSION['USERNAME'] );
        unset( $_SESSION['activeloginadmin'] );
        unset( $_SESSION['m_dmpid'] );
        unset( $_SESSION['sc_emp_status'] );
        unset( $_SESSION['sc_user_profile'] );
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->clearSessionSc();
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

                return $this->goHome();
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
            Yii::$app->session->setFlash('success', 'เปลี่ียนรหัสผ่านใหม่เรียบร้อยแล้ว.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}

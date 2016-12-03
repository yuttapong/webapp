<?php
namespace api\modules\v1\controllers;

use common\models\LoginForm;
use  common\models\User;
use frontend\models\ContactForm;
use yii\rest\Controller;
use Yii;
use yii\web\Response;

class UserController extends Controller
{
    function actionIndex()
    {
         $token = Yii::$app->request->get('access_token');
        $model = User::findIdentityByAccessToken($token);
        return $model;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            $now =  new \DateTime();
            $today = $now->format('Y-m-d H:i:s');
            $user = User::findOne(Yii::$app->user->id);
            $user->logged_in_ip = Yii::$app->request->getUserIP();
            $user->logged_in_at = $today;
            $user->generateAuthKey();
            $user->save();
            if($user){
                return [
                    'access_token' => Yii::$app->user->identity->getAuthKey(),
                    'lastLogin' => $today,
                    'ip' => $user->logged_in_ip,
                ];
            }else{
                throw  $user->errors;
            }
        } else {
            $model->validate();
            return $model;
        }
    }

/*    public function actionLogin()
    {
        $post = Yii::$app->request->post();
        $model = User::findOne(["username" => $post["username"]]);
        if (empty($model)) {
            throw new \yii\web\NotFoundHttpException('User not found');
        }
        if ($model->validatePassword($post["password"])) {
            $model->logged_in_at= Yii::$app->formatter->asTimestamp(date_create());
            $model->save(false);
            return $model; //return whole user model including auth_key or you can just return $model["auth_key"];
        } else {
            throw new \yii\web\ForbiddenHttpException();
        }
    }*/


    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            return ['success' => true];
        }
    }


    public function actionDashboard()
    {
        if (!Yii::$app->user->isGuest) {
            $response = [
                'username' => Yii::$app->user->identity->username,
                'access_token' => Yii::$app->user->identity->getAuthKey(),
            ];
            return $response;
        } else {
            return [
                'error'
            ];
        }

    }


    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }

}

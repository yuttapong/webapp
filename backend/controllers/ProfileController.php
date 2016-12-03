<?php

namespace backend\controllers;

use backend\modules\org\models\OrgPersonnel;
use Yii;
// use common\models\User;
use backend\models\User;
use frontend\models\ProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use \maxmirazh33\image\GetImageUrlTrait;


class ProfileController extends Controller
{
    public $layout = 'profile'; // set this to profile,profile2

    public function rules(){

    }

    public function behaviors()
    {
        return [
          'access' => [
              'class' => AccessControl::className(),
              'rules' => [
                  [
                      'actions' => ['index','update','profile'],
                      'allow' => true,
                  ],
              ],
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
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */


    public function actionIndex()
    {
        $profile =  OrgPersonnel::find()->where(['user_id'=>Yii::$app->user->id])->one();
        return $this->render('index', [
            'model' => $this->findModel(Yii::$app->user->id),
            'profile' => $profile,
        ]);
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findModel(Yii::$app->user->id);
        $model->password = $model->password_hash;
        $model->confirm_password = $model->password_hash;
        $oldPass = $model->password_hash;

        print_r($_POST);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($oldPass!==$model->password){
              $model->setPassword($model->password);
            }

            if($model->save()){

              Yii::$app->getSession()->setFlash('success', 'บันทึกเสร็จเรียบร้อย');
                echo Yii::getAlias('@web/images');
             return $this->redirect(['update']);
            }else{
              throw new NotFoundHttpException('พบข้อผิดพลาด!.');
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
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

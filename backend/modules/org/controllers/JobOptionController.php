<?php

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgJobOption;
use yii\filters\AccessControl;


class JobOptionController extends \yii\web\Controller
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
    public function actionIndex()
    {
        return $this->render('index');
    }
    /*
     * ดึงข้อมูล คุณสมบัติผู้สมัคร 
     */
    public function actionAjaxList($q = null,$type='property') {
    	$models = OrgJobOption::find()
    	->select('id,title')
    	->where('title LIKE "%' .trim($q) .'%" AND  status = \'1\' AND  _type = \''.$type.'\' ')
    	->asArray()->all();
    	echo json_encode($models);

    }

}

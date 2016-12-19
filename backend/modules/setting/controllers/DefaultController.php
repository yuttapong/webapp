<?php

namespace backend\modules\setting\controllers;

use backend\modules\org\models\OrgPersonnel;
use backend\modules\recruitment\models\RcmAppForm;
use backend\modules\setting\models\User;
use yii\web\Controller;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use Yii;

/**
 * Default controller for the `setting` module
 */
class DefaultController extends Controller
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $items = [
            'user' => [
                'icon' => 'fa fa-user',
                'name' => 'ผู้ใช้งาน',
                'url' => Url::to('role/index'),
                'count' => User::find()->where(['status' => User::STATUS_ACTIVE])->count(),
            ],
            'personnel' => [
                'icon' => 'fa fa-group',
                'name' => 'พนักงาน',
                'url' => Url::to('role/index'),
                'count' => OrgPersonnel::find()->where(['active' => 1])->count(),
            ],
            'recruitement' => [
                'icon' => 'fa fa-list',
                'name' => 'ใบสม้ครงาน',
                'url' => Url::to('role/index'),
                'count' => RcmAppForm::find()->count(),
            ],
            'approve' => [
                'icon' => 'fa fa-check-circle',
                'name' => 'รายการอนุมัติ',
                'url' => ['approve/list-pending'],
                'count' => RcmAppForm::find()->count(),
            ],
        ];

        return $this->render('index', [
            'items' => $items,
        ]);
    }
}

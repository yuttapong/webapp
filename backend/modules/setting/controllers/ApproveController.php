<?php

namespace backend\modules\setting\controllers;
use backend\modules\org\models\OrgStructureItem;
use Yii;
use backend\modules\org\models\OrgSite;
use common\models\SysDocument;
use common\models\SysDocumentOption;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class ApproveController extends \yii\web\Controller
{
    public  $_listApprove = [];
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
        return $this->render('index',[
                'dataProvider' =>  new ActiveDataProvider([
                    'query' => OrgSite::find(),
                ])
            ]
        );
    }

    public function actionUser()
    {
        return $this->render('index',[
                'dataProvider' =>  new ActiveDataProvider([
                    'query' => OrgSite::find(),
                ])
            ]
        );
    }


    public function actionSite($site_id)
    {
        $modelsDocument = SysDocument::find()
            ->joinWith('documentOptions')
            ->all();

        $modelsOption = SysDocumentOption::find()->where(['site_id'=>$site_id])->all();
        return $this->render('site',[
                'modelsDocument' => $modelsDocument,
                'modelsOption' => $modelsOption,
            ]
        );
    }


    /**
     *  รายการรออนุมัติทั้งหมด
     * @return string
     */
    public function actionListPending(){
        $modelsDocument = SysDocument::find()
            ->joinWith('documentOptions')
            ->all();

        $modelsOption = SysDocumentOption::find()->all();
        return $this->render('site',[
                'modelsDocument' => $modelsDocument,
                'modelsOption' => $modelsOption,
            ]
        );
    }


    /**
     *  รูปแบบการอนุมัติ
     * @return string
     */
    public function actionFormat(){
        $modelsDocument = SysDocument::find()
            ->joinWith('documentOptions')
            ->all();

        $app = $this->findRoot(179);

        $formats = SysDocumentOption::find()->all();
        return $this->render('format',[
            'formats' => $formats

            ]
        );
    }


    private function findRoot($userId){
        $model = OrgStructureItem::find()->where(['user_id'=>$userId])->one();
        $find = OrgStructureItem::find()->where(['id'=>$model->parent_id])->one();
        return  $find->id;
    }

    private  function _findRoot($id){
        $model = OrgStructureItem::find()->where(['id'=>$id])->one();
        if($model->parent_id !=0){
            $_listApprove[] = $model->id;
        }
    }




}

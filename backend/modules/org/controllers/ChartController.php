<?php
namespace backend\modules\org\controllers;
use backend\modules\org\models\OrgPersonnel;
use Yii;
use backend\modules\org\models\OrgStructureItem;
use backend\modules\org\models\Tree;
use common\models\SysMenu;
use yii\helpers\ArrayHelper;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class ChartController extends \yii\web\Controller
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
        $charts = $this->getChart();

        return $this->render('index', [
            'charts' => $charts
        ]);
    }

    public function actionManage()
    {
        return $this->render('manage');
    }

    public function actionShow()
    {
        $charts = $this->getGoJsChart();
        return $this->render('show', [
            'charts' => $charts
        ]);
    }

    public function actionGojs()
    {
        $charts = $this->getGoJsChart();
        return $this->render('gojs', [
            'charts' => $charts
        ]);
    }

    public function actionOrgchart()
    {
        $charts = $this->getGoJsChart();
        return $this->render('orgchart', [
            'charts' => $charts
        ]);
    }





    private function getParent()
    {
        $models = SysMenu::findAll(['parent' => 0]);
        $items = [];
        if ($models) {
            foreach ($models as $m) {
                $items[$m->id]['label'] = $m->name;
                $items[$m->id]['items'] = $this->getNodes($m->id);
            }
        }

        return $items;


    }

    private function getNodes($parent)
    {
        $model = SysMenu::findAll(['parent' => $parent]);
        $items = [];
        if ($model) {
            foreach ($model as $m) {
                $items[] = [
                    'label' => $m->name,
                ];
            }
        }
        return $items;
    }

    private function getChart()
    {
        $models = OrgStructureItem::find()->all();
        $items = [];
        if ($models) {
            foreach ($models as $m) {
                $items[] = [['v' => $m->id, 'f' => 'xxx'], $m->parent_id, $m->first_name];
            }
        }
        return $items;
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
                    // 'postionId' => $m->position_id,
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

    public function actionJsonOrg()
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
                   // 'postionId' => $m->position_id,
                    'name' => $m->first_name,
                    'photo' => $photo,
                   // 'headOf' => $name[0],
                ];
            };
        }
        $array = [
            'class' => '"go.TreeModel',
            'nodeDataArray' => $items,
        ];
        return  json_encode($array);
    }

}

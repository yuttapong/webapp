<?php

/**
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2015 - 2016
 * @package   yii2-tree-manager
 * @version   1.0.6
 */

namespace backend\modules\org\controllers;

use backend\modules\org\models\OrgCompany;
use backend\modules\org\models\OrgSiteUser;
use common\models\OrgSite;
use Yii;
use Closure;
use Exception;
use yii\db\Exception as DbException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\base\InvalidCallException;
use yii\web\View;
use yii\base\Event;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;

use backend\modules\org\models\TreeManager;
use kartik\tree\controllers\NodeController as NodeKatik;
use yii\helpers\Url;
use backend\modules\org\models\OrgPersonnel;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class NodeController extends NodeKatik

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
    
    public function actionEdit($company_id)
    {

        $models = TreeManager::find()->addOrderBy('root, lft');
        $models->company_id = $company_id;
        return $this->render('edit', [
            'models' => $models,
            'modelCompany' => OrgCompany::findOne($company_id),
        ]);
    }


    /**
     * Saves a node once form is submitted
     */
    public function actionSave()
    {
        $post = Yii::$app->request->post();
        if($post['TreeManager']['user_id']!=''){
        	$personner=OrgPersonnel::find()
        	->where(['user_id' => $post['TreeManager']['user_id']])
        	->one();
        	$text=explode("-",$post['TreeManager']['name']);
        	// $name=$personner->firstname_th.' '.$personner->lastname_th.' - '.(empty($text['1'])?$text['0']:$text['1'] );
        	$name=$text['0'].' - '.$personner->firstname_th.' '.$personner->lastname_th;
        	$post['TreeManager']['name']=$name;
        }
        //header("content-type:text/html;charset=utf8");
      
        static::checkValidRequest(!isset($post['treeNodeModify']));
        $treeNodeModify = $parentKey = $currUrl = null;
        $modelClass = '\kartik\tree\models\Tree';
        //$modelClass = 'backend\modules\org\models\TreeManager';
        extract(static::getPostData());
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        $session = Yii::$app->session;
        
        
        /**
         * @var Tree $modelClass
         * @var Tree $node
         * @var Tree $parent
         */
        if ($treeNodeModify) {
            $node = new $modelClass;
            $successMsg = Yii::t('kvtree', 'The node was successfully created.');
            $errorMsg = Yii::t('kvtree', 'Error while creating the node. Please try again later.');
        } else {
            $tag = explode("\\", $modelClass);
            $tag = array_pop($tag);
            $id = $post[$tag][$keyAttr];
            $node = $modelClass::findOne($id);
            $successMsg = Yii::t('kvtree', 'Saved the node details successfully.');
            $errorMsg = Yii::t('kvtree', 'Error while saving the node. Please try again later.');
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;


        $node->load($post);
 
        
        if ($treeNodeModify) {
            if ($parentKey == 'root') {
                $node->makeRoot();
            } else {
            	 $parent = $modelClass::findOne($parentKey);
            	if( $parent->lvl ==5){
            		$session->setFlash('error', $errorMsg);
            		return $this->redirect($currUrl);
            		 
            	}else{
            		$node->appendTo($parent);
            	}
            }
        }


        $errors = $success = false;


        /***********************************
         * save site for user
         * *********************************/
        $node->user_code = null;
        $node->parent_id=$post['TreeManager']['parent_id'];

        if($node->user_id > 0){
            $node->user_code = $node->personnelCode;
            $node->first_name = $node->personnelName;
            $items = Yii::$app->request->post('TreeManager');
            if ($isNewRecord) {
                //if site not empty. save to db
                if (!empty($items['sites'])) {
                    foreach ($items['sites'] as $site_id) {
                        $modelSite = new OrgSiteUser();
                        $modelSite->site_id = $site_id;
                        $modelSite->user_id = $node->user_id;
                        $modelSite->save();
                    }
                }
            } else {
                if (!empty($items['sites'])) {

                    //check to delete site
                    $modelsSiteUser = OrgSiteUser::find()->where(['user_id' => $node->user_id])->all();
                    $oldSiteIDs = ArrayHelper::map($modelsSiteUser, 'site_id', 'site_id');
                    $deletedSiteIDs = array_diff($oldSiteIDs, $items['sites']);
                    if (!empty($deletedSiteIDs)) {
                        OrgSiteUser::deleteAll([
                            'site_id' => $deletedSiteIDs,
                            'user_id' => $node->user_id
                        ]);
                    }

                    //save or update site
                    foreach ($items['sites'] as $site_id) {
                        $modelCheck = OrgSiteUser::find()
                            ->where(['user_id' => $node->user_id, 'site_id' => $site_id])
                            ->one();
                        if (@$modelCheck->site_id > 0) {

                        } else {
                            echo '<br>บันทึกใหม่';
                            $modelSite = new OrgSiteUser();
                            $modelSite->site_id = $site_id;
                            $modelSite->user_id = $node->user_id;
                            $modelSite->save();
                        }
                    }
                }


            }

        }


        // save node
        if ($node->save()) {
            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "Node # {id} - '{name}': {error}", $err) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }

        $session->set(ArrayHelper::getValue($post, 'nodeSelected', 'kvNodeId'), $node->$keyAttr);
        if ($success) {
            $session->setFlash('success', $successMsg);
        } else {
            $session->setFlash('error', $errorMsg);
        }
        
 
         return $this->redirect(Url::to(['/org/node/edit', 'tree_id' => $node->$keyAttr,'company_id'=>$node->company_id]));
    }

    /**
     * View, create, or update a tree node via ajax
     *
     * @return string json encoded response
     */
    public function actionManage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        static::checkValidRequest();
        $parentKey = $action = null;
        $modelClass = '\kartik\tree\models\Tree';
        $isAdmin = $softDelete = $showFormButtons = $showIDAttribute = false;
        $currUrl = $nodeView = $formOptions = $formAction = $breadCrumbs = $nodeSelected = '';
        $iconsList = $nodeAddlViews = [];
        extract(static::getPostData());
        /**
         * @var Tree $modelClass
         * @var Tree $node
         */

        if (!isset($id) || empty($id)) {
            $node = new $modelClass;
            $node->initDefaults();
        } else {
            $node = $modelClass::findOne($id);


        }
        $modelSiteUser = OrgSiteUser::findAll(['user_id'=>$node->user_id]);
        $node->sites = ArrayHelper::map($modelSiteUser,'site_id','site_id');
        $module = TreeView::module();
        $params = $module->treeStructure + $module->dataStructure + [
                'node' => $node,
                'parentKey' => $parentKey,
                'action' => $formAction,
                'formOptions' => empty($formOptions) ? [] : $formOptions,
                'modelClass' => $modelClass,
                'currUrl' => $currUrl,
                'isAdmin' => $isAdmin,
                'iconsList' => $iconsList,
                'softDelete' => $softDelete,
                'showFormButtons' => $showFormButtons,
                'showIDAttribute' => $showIDAttribute,
                'nodeView' => $nodeView,
                'nodeAddlViews' => $nodeAddlViews,
                'nodeSelected' => $nodeSelected,
                'breadcrumbs' => empty($breadcrumbs) ? [] : $breadcrumbs,
            ];
        if (!empty($module->unsetAjaxBundles)) {
            Event::on(View::className(), View::EVENT_AFTER_RENDER, function ($e) use ($module) {
                foreach ($module->unsetAjaxBundles as $bundle) {
                    unset($e->sender->assetBundles[$bundle]);
                }
            });
        }
        $callback = function () use ($nodeView, $params) {
            return $this->renderAjax($nodeView, ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the node. Please try again later.'),
            null
        );
    }

    public function actionSitesUser($user_id){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        $model = OrgSiteUser::find()
            ->where(['user_id'=>$user_id])
            ->all();
        if($model){
            foreach($model as $site){
                $out[] = ['id' => $site->site_id,'text' => $site->sitename];
            }

        }
        return $out;
    }

}

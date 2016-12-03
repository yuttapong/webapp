<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 1/11/2559
 * Time: 15:32
 */

namespace common\rbac;


use yii\rbac\Rule;
use Yii;

class MarketingManagerRule extends Rule{
    public $name = 'isMarketingManager';

    public function execute($user, $item, $params) { //abstract method implement
        //return isset($params['post']) ? $params['post']->user_id == $user : false;
        if(isset($params['model'])){
            $model = $params['model'];
        }else{
            $id = Yii::$app->request->get('id');
            $model = Yii::$app->controller->findModel($id);
        }
        return $model->created_by == $user;
    }

}
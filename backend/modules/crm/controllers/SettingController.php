<?php

namespace backend\modules\crm\controllers;


use Yii;
use backend\modules\crm\models\Customer;
use backend\modules\org\models\OrgPersonnel;
use backend\modules\crm\models\UserTeam;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\Response;

class SettingController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSurvey()
    {
        return $this->render('index');
    }

    public function actionCe()
    {
        $team = $this->findUserTeamAll();
        $userItems = [];
        if($team) {
            foreach ($team as $u) {
                $input = "<input type=\"hidden\" name=\"users[]\" value=\"".$u->user_id."\"> ";
                $button = "<button  type=\"button\" class=\"btn btn-danger btn-xs btn-removeassign\"><i class=\"fa fa-trash\"></i></button> ";
                $userItems[$u->user_id] = $input.$button . $u->name;
            }
        }


        return $this->render('ce',
            [ 'userItems' => $team,'userTeam' => new UserTeam() ]
        );
    }


    public function actionFindCustomer($q)
    {
        $out = [];
        if ($q) {
            $customers = OrgPersonnel::find()
                ->andFilterWhere(['like', 'firstname_th', $q])
                ->orFilterWhere(['like', 'lastname_th', $q])
                ->all();
            $out = [];
            foreach ($customers as $d) {
                $out[] = [
                    'id' => $d->user_id,
                    'value' => $d->fullnameTH,
                    'name' => $d->code . ' - ' . $d->fullnameTH
                ];
            }
        }
        echo Json::encode($out);
    }

    public function actionSaveAssignTeam()
    {
        $rs['status'] = 0;
        $rs['message'] = '';
        if (\Yii::$app->request->isAjax) {
            $users = \Yii::$app->request->post('users');
            UserTeam::deleteAll();
            if(count($users) > 0) {
                $users = array_unique($users);
                foreach ($users as $user_id) {

                    $u = OrgPersonnel::find()->where(['user_id'=>$user_id])->one();
                    $created_name = $u->fullnameTH;

                    $user = new UserTeam();
                    $user->user_id = $user_id;
                    $user->created_at = time();
                    $user->created_by = Yii::$app->user->id;
                    $user->name = $created_name;
                    $user->save();
                }

                if($user) {
                    $rs['result'] = 1;
                    $rs['message'] = 'บันทึกข้อมูลเรียบร้อยแล้ว';
                    $rs['rows'] = $this->findUserTeamAll();
                }
            }
            echo Json::encode($rs);
        }

    }


    private function findUserTeamAll() {
        return UserTeam::find()->orderBy(['created_at'=> SORT_ASC])->all();
    }


}

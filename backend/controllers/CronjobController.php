<?php

namespace backend\controllers;

use Yii;
use backend\models\Bemployee;
use backend\modules\org\models\OrgPersonnel;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CronjobController extends \yii\web\Controller
{
    public function actionCloneEmployee()
    {

        $models = Bemployee::find()->where("EMP_STATUS in(0,1,2)")
            ->all();
        $dest = ArrayHelper::map($models, 'EMPID', 'EMPID');
        $tartget = ArrayHelper::map(OrgPersonnel::find()->all(), 'code', 'code');

        $loop = 0;
        foreach ($models as $model) {
            $path = '';
            $img = Html::img("/sc/hr/picture/" . $model->Picture, ['style' => 'width:80px;']);
            $find = OrgPersonnel::find()->where(['code' => $model->EMPID])->one();

            if (!$find) {
                $loop++;
                $find->code = $model->EMPID;
                $find->firstname_th = trim($model->EMPFNAME);
                $find->lastname_th = trim($model->EMPLNAME);
                $find->nickname = trim($model->NickName);
                $find->start_working = $model->START;
                $find->birthday = $model->BirthDay;
                $find->weight = $model->Weight;
                $find->height = $model->Height;

                if ($model->EMP_STATUS == 0) {
                    $find->active = 0;
                }
                if ($model->EMP_STATUS == 1 || $model->EMP_STATUS == 2) {
                    $find->active = 1;
                }
                if (trim($model->Religion) == 'พุทธ') {
                    $find->religion = 'Buddhism';
                } else {
                    $find->religion = null;
                }
                //$find->save(false);
                echo "<pre> 
                 $loop) $find->firstname_th $find->lastname_th ($find->nickname) 
                          รหัสพนักงาน: $find->code
                          วันที่เริ่มงาน: $find->start_working
                          สถานะ: $find->active
                          วันเกิด: $find->birthday
                          ศาสนา: $find->religion
                          นำหนัก: $find->weight
                          สูง: $find->height
                          <hr>
                </pre>";


            }

            if (!$find) {
                $loop++;
                //  echo'<p>' .  $loop . ') ' .  $img . $model->EMPID .' ' . $model->EMPFNAME.' '.$model->EMPLNAME . '</p>';
                $user = new OrgPersonnel();
                $user->code = $model->EMPID;
                $user->firstname_th = $model->EMPFNAME;
                $user->lastname_th = $model->EMPLNAME;
                $user->nickname = $model->NickName;
                $user->start_working = $model->START;
                $user->birthday = $model->BirthDay;
                $user->weight = $model->Weight;
                $user->height = $model->Height;

                if ($model->EMP_STATUS == 0) {
                    $user->active = 0;
                }
                if ($model->EMP_STATUS == 1 || $model->EMP_STATUS == 2) {
                    $user->active = 1;
                }
                if (trim($model->Religion) == 'พุทธ') {
                    $user->religion = 'Buddhism';
                } else {
                    $user->religion = null;
                }
                $user->save(false);

                $login = User::find()->where(['username' => $model->EMPID])->one();
                $t = '';
                if (!$login) {
                    $t = ' (ไม่มี usernamec)';
                    $newuser = new User();
                    $newuser->username = $model->EMPID;
                    $newuser->created_at = time();
                    $newuser->status = User::STATUS_ACTIVE;

                    //$newuser->password_hash =  Yii::$app->security->generatePasswordHash($model->EMPID);
                    //$newuser->auth_key =  Yii::$app->security->generateRandomString();
                }

                echo "<pre> 
                 $loop) $user->firstname_th $user->lastname_th ($user->nickname)  $t
                          รหัสพนักงาน: $user->code
                          วันที่เริ่มงาน: $user->start_working
                          สถานะ: $user->active
                          วันเกิด: $user->birthday
                          ศาสนา: $user->religion
                          นำหนัก: $user->weight
                          สูง: $user->height
                          Username: $newuser->username
                          created_at: $newuser->created_at
                          userStatus: $newuser->status
                         
                          
                          <hr>
                </pre>";
            }
        }

        echo '<pre>';
        print_r(array_diff($dest, $tartget));
        echo '<pre>';
    }

}

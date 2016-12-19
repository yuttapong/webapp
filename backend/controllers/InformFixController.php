<?php

namespace backend\controllers;

use backend\modules\fix\models\InformFix;
use backend\modules\fix\models\SendDocuments;
use common\models\User;
use Yii;

class InformFixController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (isset($_GET['v'])) {
            $this->layout = 'inform-fix';
            $model = new InformFix();
            $request = \Yii::$app->request;
            $key = [];
            if (!empty($_GET['v'])) {
                $key = \Yii::$app->queryString->decode($request->get('v'));
                if (!empty($key['id'])) {
                    $model = InformFix::findOne($key['id']);
                        return $this->render('index', [
                            'model' => $model,
                            'dataKey' => $key,
                        ]);
                }

            }
        }
    }

    public function actionSendAcknowledge($id, $user_id)
    {

        $modelSen = SendDocuments::findOne(
            ['table_name' => 'fix_inform_fix', 'table_key' => $id, 'recipient_user_id' => $user_id, 'is_khow' => '0']
        );
        if (count($modelSen) > 0) {
            return $this->renderAjax('_form-sen-acknowledge', [
                'modelSen' => $modelSen,
                'user_id' => $user_id,
            ]);
        }
    }

    public function actionSaveDoc($id)
    {
        $modelSen = SendDocuments::findOne($id);

        $request = \Yii::$app->request;
        $user_id = $request->post('user_id');
        $password = $request->post('SendDocuments');
        $user = User::findOne($user_id);
        $checkUser = $user->validatePassword(trim($password['password']));

        if ($checkUser == 1) {
            $post = \Yii::$app->request->post();
            if ($post) {
                $option = unserialize($modelSen->option);

                if (!empty($post['SendDocuments']['option'])) {
                    $old_option = unserialize($modelSen->option);
                    foreach ($post['SendDocuments']['option'] as $key => $val) {
                        if ($key == 'text_khow') {
                            $option['text_khow'] = $val;
                        }
                    }
                    $modelSen->option = serialize($option);
                    $modelSen->is_khow = $post['SendDocuments']['is_khow'];
                    $modelSen->save();

                    $modelisApp = \common\models\ListMessage::findOne(
                        ['table_name' => $modelSen->table_name, 'table_key' => $modelSen->table_key, 'table_key2' => $modelSen->id]
                    );
                    $modelisApp->app_status = 2;
                    $modelisApp->status = 1;
                    $modelisApp->save();
                    echo 1;
                    exit();

                }
            }


        } else {

            echo 'รหัสไม่ถูกต้อง';
            return $this->renderAjax('_form-sen-acknowledge', [
                'modelSen' => $modelSen,
            ]);
        }


    }

}

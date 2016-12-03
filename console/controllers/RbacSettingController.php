<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 1/11/2559
 * Time: 15:43
 */
#RbacController.php
//yii rbac/hello
namespace console\controllers;

use yii\console\Controller;
use Yii;

class RbacSettingController extends Controller
{
    public function actionHello()
    {
        echo 'Hello';
    }

    public function actionCreateModulePermission(){
        $auth = Yii::$app->authManager;

        $settingModuleIndex = $auth->createPermission('/setting/sys-module/index');
        $settingModuleIndex->description = 'รายชื่อโมดูลหรือเมนูที่จะแสดวหน้าแรก';
        $auth->add($settingModuleIndex);

        $settingModuleCreate = $auth->createPermission('/setting/sys-module/create');
        $settingModuleCreate->description = 'เพิ่มโมดูล';
        $auth->add($settingModuleCreate);

        $settingModuleUpdate = $auth->createPermission('/setting/sys-module/update');
        $settingModuleUpdate->description = 'แก้ไขโมดูล';
        $auth->add($settingModuleUpdate);


        $settingModuleDelete = $auth->createPermission('/setting/sys-module/delete');
        $settingModuleDelete->description = 'ลบโมดูล';
        $auth->add($settingModuleDelete);

        echo 'Create Permission module success!';

    }


    public function actionCreateBasicDataPermission(){
        $auth = Yii::$app->authManager;

        $settingDataIndex = $auth->createPermission('/setting/sys-basic-data/index');
        $settingDataIndex->description = 'รายการกลุ่มข้อมูล';
        $auth->add($settingDataIndex);

        $settingDataCreate = $auth->createPermission('/setting/sys-basic-data/create');
        $settingDataCreate->description = 'เพิ่มกลุ่มข้อมูล';
        $auth->add($settingDataCreate);

        $settingDataUpdate = $auth->createPermission('/setting/sys-basic-data/update');
        $settingDataUpdate->description = 'แก้ไขกลุ่่มข้อมูล';
        $auth->add($settingDataUpdate);


        $settingDataDelete = $auth->createPermission('/setting/sys-basic-data/delete');
        $settingDataDelete->description = 'ลบกลุ่มข้อมูล';
        $auth->add($settingDataDelete);

        echo 'Create Permission Basic data success!';

    }


    public function actionCreateRole() {

    }

}
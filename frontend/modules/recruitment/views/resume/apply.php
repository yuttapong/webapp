<?php

use yii\helpers\Html;
use beastbytes\wizard\WizardMenu;


/* @var $this yii\web\View */
/* @var $model frontend\models\RcmAppForm */

$this->title = 'แบบฟอร์มสมัครงาน: ';
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงาน', 'url' => ['position/index']];
$this->params['breadcrumbs'][] =  'สมัครงาน';
?>
 <?=$this->render('_form-apply', [
        'model' => $model,
        'modelPersonnel' => $modelPersonnel,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsPosition' => $modelsPosition,
        'citizenAmphur' => $citizenAmphur,
    ]) ?>



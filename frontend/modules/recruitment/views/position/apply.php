<?php

use yii\helpers\Html;
use beastbytes\wizard\WizardMenu;


/* @var $this yii\web\View */
/* @var $model frontend\models\RcmAppForm */

$this->title = 'แบบฟอร์มสมัครงาน: ' .$modelPosition->name_th;
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงาน', 'url' => ['position/index']];
$this->params['breadcrumbs'][] =  $modelManpower->position->name_th;
$this->params['breadcrumbs'][] =  'สมัครงาน';
?>
 <?=$this->render('_form', [
        'model' => $model,
        'modelManpower' => $modelManpower,
        'modelPersonnel' => $modelPersonnel,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsPosition' => $modelsPosition,
        'citizenAmphur' => $citizenAmphur,
        'citizenAmphur' => $citizenAmphur,
        'initialPreviewPhoto' => $initialPreviewPhoto,
        'initialPreviewPhotoConfig' => $initialPreviewPhotoConfig,
    ]) ?>



<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title =  $model->fullnameTH;
$this->params['breadcrumbs'][] = ['label' => 'บุคลากร', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fullnameTH, 'url' =>
    ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="org-personnel-update">


    <?= $this->render('_form', [
        'model' => $model,
        'tab' => $tab,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsReasonLeaving' => $modelsReasonLeaving,
        'modelsPosition' => $modelsPosition,
        'modelsGallery' => $modelsGallery,
        'citizenAmphur' => $citizenAmphur,
        'initialPreviewPhoto'=> $initialPreviewPhoto,
        'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,

    ]) ?>

</div>

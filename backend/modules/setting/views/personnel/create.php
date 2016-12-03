<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPersonnel */

$this->title = 'เพิ่มบุคลากร';
$this->params['breadcrumbs'][] = ['label' => 'บุคลากร', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-personnel-create">


    <?= $this->render('_form', [
        'model' => $model,
        'tab' => $tab,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'modelsReasonLeaving' => $modelsReasonLeaving,
        'modelsPosition' => $modelsPosition,
        'citizenAmphur' => $citizenAmphur,
        'initialPreviewPhoto'=> $initialPreviewPhoto,
        'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,
    ]) ?>

</div>

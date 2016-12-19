<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFix */

$this->title = 'Update แจ้งซ้อม เลขที่ ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Inform Fixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inform-fix-update">

  

    <?= $this->render('_form', [
        'model' => $model,
    	'modelhome'=>$modelhome,
    	'modelJob' =>$modelJob,
    		'initialPreview'=>$initialPreview,
    		'initialPreviewConfig'=>$initialPreviewConfig
    ]) ?>

</div>

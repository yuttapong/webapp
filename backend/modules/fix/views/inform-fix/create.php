<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFix */

$this->title = 'เพิ่มแจ้งซ่อม ';
$this->params['breadcrumbs'][] = ['label' => 'Inform Fixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inform-fix-create">

  <?= $this->render('_form', [
        'model' => $model,
    	'modelhome'=> $modelhome,
    	'modelJob' =>$modelJob,
  		   'initialPreview'=>[],
        'initialPreviewConfig'=>[]
    ]) ?>

  

</div>

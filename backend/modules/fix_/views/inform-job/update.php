<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformJob */

$this->title = 'Update Inform Job: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inform Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerJsFile('@web/js/fix/inform_fix.js');
?>
<div class="inform-job-update">
    <?= $this->render('_form', [
        'model' => $model,
    	'modelInven' => $modelInven,
    ]) ?>
</div>

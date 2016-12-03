<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformJob */

$this->title = 'Create Inform Job';
$this->params['breadcrumbs'][] = ['label' => 'Inform Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerJsFile('@web/js/fix/inform_fix.js');
?>
<div class="inform-job-create">
    <?= $this->render('_form', [
        'model' => $model,
    	'modelInven' => $modelInven,
    ]) ?>

</div>

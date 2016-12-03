<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\QtnQuestion */

$this->title = 'Update Qtn Question: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Qtn Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="qtn-question-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	  'survey_tab' =>	$survey_tab,
    		'survey_title' =>	$survey_title
    ]) ?>

</div>

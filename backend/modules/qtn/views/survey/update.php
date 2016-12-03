<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\Survey */

$this->title = 'Update Survey: ' . $modelsSurvey->name;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelsSurvey->name, 'url' => ['view', 'id' => $modelsSurvey->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="survey-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'modelsSurvey' => $modelsSurvey,
    		'modelsTab' => $modelsTab,
    		'modelsTitle' => $modelsTitle,
    ]) ?>
</div>

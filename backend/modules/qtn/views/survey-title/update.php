<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SurveyTitle */

$this->title = 'Update Survey Title: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Survey Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="survey-title-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

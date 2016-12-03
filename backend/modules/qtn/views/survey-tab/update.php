<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SurveyTab */

$this->title = 'Update Survey Tab: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Survey Tabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="survey-tab-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

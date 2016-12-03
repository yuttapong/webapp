<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SurveyTitle */

$this->title = 'Create Survey Title';
$this->params['breadcrumbs'][] = ['label' => 'Survey Titles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-title-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

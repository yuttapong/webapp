<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SurveyTab */

$this->title = 'Create Survey Tab';
$this->params['breadcrumbs'][] = ['label' => 'Survey Tabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-tab-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

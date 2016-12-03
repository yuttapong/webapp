<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\models\Questionnaire */

$this->title = 'Update Questionnaire: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="questionnaire-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

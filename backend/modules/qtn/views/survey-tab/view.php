<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SurveyTab */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Survey Tabs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-tab-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'survey_id',
            'name',
            'hide',
            'description:ntext',
        ],
    ]) ?>

</div>

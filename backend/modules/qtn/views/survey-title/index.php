<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\qtn\Models\SurveyTitleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Survey Titles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-title-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Survey Title', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'survey_id',
            'survey_tab_id',
            'name:ntext',
            'hide',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

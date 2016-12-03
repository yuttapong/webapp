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
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name:ntext',
            [
            'label'=>'Choice',
            'format' => 'raw',
            'value'=>function ($data) {
            	return Html::a('ตารางตัวเลือกหลายข้อ', '/qtn/survey/choice-title?id=' . $data->id);
            },
            ],
        ],
    ]); ?>
</div>

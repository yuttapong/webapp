<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\modules\qtn\models\Survey;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\qtn\Models\SurveySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Qtn Surveys';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtn-survey-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Qtn Survey', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
      //  'filterModel' => $searchModel,
        'showPageSummary'=>true,
        'pjax'=>true,
        'striped'=>true,
        'hover'=>true,
        'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
        'columns' => [
             ['class'=>'kartik\grid\SerialColumn'],
             [
             'attribute'=>'id',
             'format' => 'raw',
             'width'=>'310px',
             'value'=>function ($model, $key, $index, $widget) {
             $txt= $model->surveyTab->survey->name;
             if($model->surveyTab->survey->status==0){
             	$txt .= '&nbsp;'.Html::a('<span class="	glyphicon glyphicon-pencil"></span>',[ 'survey/update?id=' . $model->surveyTab->survey_id]);
             }
             $txt .=  '___' .Html::a('<span class="glyphicon glyphicon-list-alt"></span>',[ 'survey/view?id=' .$model->surveyTab->survey_id]);
             		return $txt;
             },
             		'filterInputOptions'=>['placeholder'=>'Any supplier'],
             				'group'=>true,  // enable grouping,
             				'groupedRow'=>true,                    // move grouped column to a single grouped row
             				'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
             				'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
           ],
             		
            [
            'attribute'=>'survey_tab_id', 
            'width'=>'310px',
            'value'=>function ($model, $key, $index, $widget) { 
               return $model->surveyTab->name;
            },
            'group'=>true, 
        ],
            [
          
            'attribute'=>'name',
            'format' => 'raw',
            'value'=>function ($data) {
            $txt= $data->name;
            if($data->surveyTab->survey->status==0){
            	$txt .= '&nbsp;'.Html::a('คำถาม',[ 'survey/question?id=' . $data->surveyTab->survey_id]);
            	//$txt .=Html::a('table',[ 'survey/choice-title?id=' . $data->id]);
            }
            	return $txt;
            },
            ],
        ],
    ]); ?>
</div>

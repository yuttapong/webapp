<?php

use yii\bootstrap\Html;
use kartik\grid\GridView;
use common\helpers\UrlRule;
use backend\modules\qtn\models\Question;
use kartik\tabs\TabsX;
use backend\modules\qtn\models\QuestionType;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CustomerSearch $searchModel
 */

$this->title =  $modelSurvey->name;
$this->params['breadcrumbs'][] = 'รายงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-index">
    <div class="page-header">
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a('Create Customer', ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => 'พนักงาน',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->orgPersonnel->fullnameTH,['survey', 'surveyId' => $model->survey_id,'userId'=>$model->created_by], [
                        'title' => Yii::t('yii', 'Edit'),
                    ]);
                }
            ],
            [
                'header' => 'จำนวนแบบสอบถาม',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(\backend\modules\crm\models\Survey::countSurveyByUser($model->survey_id,$model->created_by),['survey','surveyId' => $model->survey_id,'userId'=>$model->created_by], [
                        'title' => Yii::t('yii', 'Edit'),
                    ]);
                }
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        /*
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
            'type' => 'default',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
        */
    ]);
  ?>

</div>


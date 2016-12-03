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

$this->title = $modelUser->fullnameTH;
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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'header' => 'รหัสลูกค้า',
                'value' =>  'customer.id',
            ],
            'customer.fullname',
            [
                'header' => 'ชื่อแบบสอบถาม',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->survey->name,['response/view', 'id' => $model->id], [
                        'title' => 'คลิกดูรายละเอียด',
                        'target' => '_blank',
                    ]);
                }
            ],
            [
                'header' => 'ผูัจัดทำ',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->created->fullnameTH;
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


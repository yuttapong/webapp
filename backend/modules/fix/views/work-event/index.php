<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use common\siricenter\thaiformatter\ThaiDate;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\WorkEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'ตารางงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-event-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'title',
            [
            'attribute' =>   'description',
            'format' => 'raw',
            'value' => function ($model) {
          
            	return $model->description;
            },
            ],
            [
            'attribute' =>   'start_date',
            'format' => 'raw',
            'value' => function ($model) {
            	$date_modify='';
            	if($model->start_date!=''){
            		$date_modify=  ThaiDate::widget([
            				'timestamp' => $model->start_date,
            				'type' => ThaiDate::TYPE_MEDIUM,
            				'showTime' => false   ]);
            	}
            	return $date_modify;
            },
            ],
            [
            'attribute' =>   'end_date',
            'format' => 'raw',
            'value' => function ($model) {
            	$date_modify='';
            	if($model->end_date!=''){
            		$date_modify=  ThaiDate::widget([ 
            				'timestamp' => $model->end_date, 
            				'type' => ThaiDate::TYPE_MEDIUM, 
            				 'showTime' => false   ]);
            	}
            	return $date_modify;
            },
            ],
            [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'status',
            'vAlign'=>'middle',
            ],
            // 'create_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

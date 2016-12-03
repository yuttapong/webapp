<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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

           // 'id',
            'title',
            'description',
            'start_date:datetime', 
            'end_date:datetime',
            [
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'status',
            'vAlign'=>'middle',
            ],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    $appStatus = '';
                    if ($model->status == '1') {
                        $appStatus = '<span class="app-status label label-success" >'.$model->statusName.'</span>';
                    } elseif($model->status =='0') {
                        $appStatus = '<span class="app-status label label-danger" > '. $model->statusName .'</span>';
                    }
                    return $appStatus;
                }
            ],
            'status',
            // 'create_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php

use yii\helpers\Html;

use yii\helpers\Url;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\InformJobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inform Jobs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inform-job-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'informFix.code',
            'list',
            'problem:ntext',
            'solution:ntext',
            //'description:ntext',
             [
             'class'=>'kartik\grid\BooleanColumn',
             'attribute'=>'status',
             'vAlign'=>'middle',
            ],
            // 'job_list_id',
            // 'created_at',
            // 'created_by',
            // 'responsible_id',
            // 'responsible_name',
            // 'job_status',
            // 'pate_price',
            // 'net_price',
            // 'apprever_type',
            [
            'class' => 'yii\grid\ActionColumn',
            
            'buttons' => [
            		'edit' => function ($url, $model) {
            			$url=Url::to(['/fix/inform-job/update','inform_fix_id'=>$model->inform_fix_id,'job_id'=>$model->id]) ;
            			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url);
            		},
            					'view' => function ($url, $model) {
            					$url=Url::to(['/fix/inform-job/view','id'=>$model->id]) ;
            					return Html::a('ดู', $url);
            									}
            											],
            													'template' => '{edit}{view}'
            ],
          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

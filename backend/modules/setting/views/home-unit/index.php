<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\HomeUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Homes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Home', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter' => $searchModel->getProjectItems(),
            ],
            [
                'attribute' => 'plan_no',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->plan_no,['view','id'=>$model->id],[
                        'class' => 'badge'
                    ]);
                }
            ],
            [
                'attribute' => 'home_no',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->home_no,['view','id'=>$model->id],[
                        'class' => ''
                    ]);
                }
            ],
            'customer_name',
             'status:boolean',
            // 'type',
            // 'home_prices',
            // 'land',
            // 'use_area',
            // 'home_status',
            // 'compact_status',
            // 'transfer_status',
            // 'created_at',
            // 'created_by',
            [
                'attribute' => 'date_insurance',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->date_insurance,
                        'showTime' => false,
                    ]);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->updated_at,
                        'showTime' => true,
                    ]);
                }
            ],
            [
                'attribute' => 'date_insurance',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->date_insurance,
                        'showTime' => false,
                    ]);
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

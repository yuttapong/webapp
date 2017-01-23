<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\bootstrap\Html;

?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'active',
            'format' => 'raw',
            'filter' => [
                0 => 'Inactive',
                1 => 'Active'
            ],
            'value' => function ($model) {
                return ($model->active == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger']);
            }
        ],
        'id',
        [
            'attribute' => 'subject',
            'value' => function ($model) {
                return Html::a($model->subject, ['view', 'id' => $model->id, 'title' => $model->subject]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'created_by',
            'value' => 'userCreated.fullnameTH',
        ],


        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>

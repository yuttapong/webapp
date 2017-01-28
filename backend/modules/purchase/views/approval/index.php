<?php

/* @var $this yii\web\View */

use yii\bootstrap\Html;
use yii\grid\GridView;

$this->title = 'List of Approval';


?>

<div class="well">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
</div>


<?= GridView::widget([
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        /*        [
                    'attribute' => 'active',
                    'format' => 'raw',
                    'filter' => [
                        0 => 'Inactive',
                        1 => 'Active'
                    ],
                    'value' => function ($model) {
                        return ($model->active == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger']);
                    }
                ],*/
        [
            'attribute' => 'approve_status',
            'value' => 'statusNameColor',
            'format' => 'html',
            'options' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'attribute' => 'created_at',
            'value' => function ($model) {
                return \common\siricenter\thaiformatter\ThaiDate::widget([
                    'timestamp' => $model->created_at,
                    'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_MEDIUM,
                    'showTime' => false,
                ]);
            },
            'format' => 'raw'
        ],

        'code',
        [
            'attribute' => 'subject',
            'value' => function ($model) {
                $url = $urlCancel = \backend\components\QueryString::encode(['view', 'id' => $model->id]);
                return Html::a($model->subject, $url, [
                    'title' => $model->subject
                ]);
            },
            'format' => 'raw'
        ],

        [
            'attribute' => 'created_by',
            'value' => 'userCreated.fullnameTH',
        ],


        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {cancel}',
            'buttons' => [
                'view' => function ($url, $model) {
                    $urlCancel = \backend\components\UrlNcode::to(['view', 'id' => $model->id]);
                    return Html::a('<i class="fa fa-search"></i> Detail', $urlCancel, [
                        'title' => 'รายละเอียด',
                        'class' => 'btn-xs btn btn-default'
                    ]);
                },
                'cancel' => function ($url, $model) {
                    if ($model->canCancel()) {
                        $urlCancel = \backend\components\UrlNcode::to(['cancel', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-ban"></i> Cancel', $urlCancel, [
                            'title' => 'ยกเลิก',
                            'data-confirm' => 'ต้องการยกเลิกรายการนี้ใช่หรือไม่ ?',
                            'class' => 'btn-xs btn btn-danger'
                        ]);
                    }
                },
                'update' => function ($url, $model) {
                    if ($model->canUpdate()) {
                        $urlCancel = \backend\components\UrlNcode::to(['update', 'id' => $model->id]);
                        return Html::a('<i class="fa fa-edit"></i> Edit', $urlCancel, [
                            'title' => 'ยกเลิก',
                            'class' => 'btn-xs btn btn-default',
                        ]);
                    }
                }
            ]
        ],
    ],
]); ?>

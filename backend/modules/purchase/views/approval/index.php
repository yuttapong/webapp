<?php

/* @var $this yii\web\View */

use yii\grid\GridView;
use yii\bootstrap\Html;
use yii\helpers\Url;
use backend\modules\purchase\models\ApproverComfirm;
use backend\modules\purchase\models\ListApproval;
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

        'code',
        [
            'attribute' => 'subject',
            'value' => function ($model) {
                return Html::a($model->subject, ['view', 'id' => $model->id, 'title' => $model->subject]);
            },
            'format' => 'raw'
        ],
        [
            'attribute' => 'created_at',
            'value' => function($model) {
                return \common\siricenter\thaiformatter\ThaiDate::widget([
                    'timestamp' => $model->created_at,
                    'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_MEDIUM,
                    'showTime' => false,
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
            'template' => '{view} {cancel}',
            'buttons' => [
                'cancel' => function($url,$model) {
                    if($model->approve_status != ListApproval::STATUS_CANCELED) {
                        return Html::a('ยกเลิก',['cancel', 'id' => $model->id],[
                            'data-confirm' => 'ต้องการยกเลิกรายการนี้ใช่หรือไม่ ?'
                        ]);
                    }
                }
            ]
        ],
    ],
]); ?>

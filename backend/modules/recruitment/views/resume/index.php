<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ใบสมัครงาน';
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('_search', ['model' => $searchModel]) ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    //'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'code',
            'value' => function ($model) {
                $img = Html::img($model->photoUrl, [
                    'class' => 'img img-responsive img-thumbnail',
                    'width' => 120
                ]);
                return '<div align="center">' . $model->code . '<br>' . Html::a($img, ['view', 'id' => $model->id]) . '</div>';
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'fullname',
            'value' => function ($model) {
                if($model->personnel) {
                     return Html::a($model->personnel->fullnameTH, ['view', 'id' => $model->id]);
                }
            },
            'format' => 'raw',
        ],
        [
            'header' => 'ตำแหน่งที่สมัคร',
            'value' => function ($model) {
                if ($positions = $model->applyPositions) {
                    $html = '';
                    $loop = 1;
                    foreach ($positions as $p) {
                        $number = count($positions)>1?$loop.') ':'';
                        $html .= Html::tag('p', $number . $p->position->name_th,['class'=>'']);
                        $loop++;
                    }
                    return $html;
                }
            },
            'format' => 'raw'
        ],
      //  'interview_status',
        [
            'attribute' => 'status',
            'value' => 'statusName',
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \backend\modules\recruitment\models\RcmAppForm::getStatusItems(),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => '--select--'],
            'options' => ['style' => 'width:200px',]
        ],
        // 'type',
        // 'status',
        // 'description:ntext',
        // 'position_id',
        'created_at:date',
        // 'created_by',

        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [

            ],
            'template' => "{view} {update}",
        ],
    ],
]); ?>


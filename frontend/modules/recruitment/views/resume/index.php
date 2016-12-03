<?php

use yii\bootstrap\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ใบสมัครงาน';
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<p>
    <?=$this->render('_search',['model'=>$searchModel])?>
</p>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'code',
            'hAlign' => 'center',
            'value' => function ($model) {
                $img = Html::img($model->photoUrl, [
                    'class' => 'img img-responsive img-thumbnail',
                    'width' => 100
                ]);
                return Html::tag('div',$img.'<div>'.$model->code.'<div>');
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'fullname',
            'value' => function ($model) {
                return Html::a(@$model->personnel->fullnameTH, ['view', 'id' => $model->id]);
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
       // 'interview_status',
        // 'type',
         'statusName',
        // 'description:ntext',
        // 'position_id',
        'created_at:date',
        // 'created_by',

        [
            'class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'quiz' => function($url,$model){
                    return  Html::a('ทำแบบสอบถาม',['quiz','id'=>$model->id]);
                }

            ],
            'template' => "{view} {update} {quiz}",
        ],
    ],
]); ?>


<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use common\models\SysTable;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SysBasicDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title =  "ข้อมูลพื้นฐาน";

$this->params['breadcrumbs'][] = ['label' => 'ชุดข้อมูลพื้นฐาน', 'url' => ['sys-table/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-basic-data-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'เพิ่มข้อมูล'),
            ['create','table_id'=>null],
            ['class' => 'btn btn-success']
        ) ?>
    </p>

    <?= GridView::widget([
        'floatHeader' => false,
        'bordered' => true,
        'pjax' => true,
        'hover' => true,
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'table_id',
                'value' => 'sysTable.name',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>SysTable::getArrayTable(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'หมวดหมู่'],
                 'group'=>true,  // enable grouping
            ],
            /*
            [
               // 'header' => 'กลุ่มข้อมูล',
                'attribute' => 'table_id',
                'filter' => $sysTables,
                'value' => 'sysTable.name'
            ],
            */

            'code',
            'name',
            [
                'attribute' => 'is_deleted',
                'format' => 'raw',
                'value' => function ($model, $index, $widget) {
                    return Html::checkbox('is_deleted[]', $model->is_deleted,
                        ['value' => $index, 'disabled' => true]);
                },
                'filter'=> ['0'=>'ยังไม่ลบ','1'=>'ลบแล้ว']

            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'status',
                'vAlign'=>'middle',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group">{role} {view} {update} {delete} </div>',
            ],
        ],
    ]); ?>

</div>

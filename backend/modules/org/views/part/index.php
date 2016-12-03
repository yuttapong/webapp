<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ส่วนงาน';
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
if (Yii::$app->request->get('division_id')) {
    $this->params['breadcrumbs'][] = [
        'label' => $modelDivision->name
    ];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-part-index">


    <p>
        <?= Html::a('สร้างส่วนงาน', ['create-part', 'division_id' => Yii::$app->request->get('division_id')], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'division_id',
                'value' => 'orgDivision.name',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' =>\backend\modules\org\models\OrgDivision::getDivisionList(),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => false],
                ],
                'filterInputOptions' => ['placeholder' => '--select--']
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->name, ['departments',
                        'divistion_id' => $data->division_id,
                        'part_id' => $data->id,

                    ]);
                }
            ],
            [
                'header' => 'จำนวนแผนก',
                'value' => function ($model) {
                    return $model->countDepartment;
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-search"></i>', ['part','id'=>$model->id]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-edit"></i>', ['update-part','id'=>$model->id]);
                    },
                ]
            ],
        ],
    ]); ?>
</div>

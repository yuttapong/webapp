<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgDepartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'แผนก';
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['index']
];
if (Yii::$app->request->get('part_id')) {


    $this->params['breadcrumbs'][] = [
        'label' => $searchModel->orgPart->orgDivision->name,
        'url' => ['parts', 'division_id' => $searchModel->orgPart->orgDivision->id]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $searchModel->orgPart->name,
        'url' => ['departments', 'part_id' => $searchModel->part_id]
    ];
}

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-department-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('สร้างแผนก', ['create-department',
            'part_id' => Yii::$app->request->get('OrgDepartmentSearch[part_id]')?Yii::$app->request->get('OrgDepartmentSearch[part_id]'):Yii::$app->request->get('part_id')
        ], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'code',
                'width' => '80px',
            ],
           // 'orgDivision.name',
            [
                'attribute' => 'part_id',
                'value' => 'orgPart.name',
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => $searchModel->getPartList(),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => false],
                ],
               // 'filterInputOptions' => ['placeholder' => '--select--']
            ],
            'name',
            [
                'attribute'=>'email',
                'width' => '150px',
                'format' => 'email',
            ],
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-search"></i>', ['department', 'id' => $model->id]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-edit"></i>', ['update-department', 'id' => $model->id]);
                    },
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>

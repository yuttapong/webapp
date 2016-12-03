<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\SysMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'เมนู';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-menu-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('สร้างเมนู', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'module_id',
                'value' => function ($model, $key, $index, $widget) {
                    return $model->module->name_th;
                },
                'filterType' => GridView::FILTER_SELECT2,
                'filter' => \common\models\SysModule::getArrayModule(),
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filterInputOptions' => ['placeholder' => 'หมวดหมู่'],
                'group' => true,  // enable grouping
            ],
            'id',
            [
                'attribute' => 'name',
                'value' => function ($model) {
                    if ($model->is_header) {
                        return "<strong>{$model->name}</strong>";
                    } else {
                        return '- ' . $model->name;
                    }
                },
                'format' => 'raw'
            ],


            'route',
            'parent',
            // 'order',
            // 'data:ntext',
            // 'table_id',
            // 'table_key',
            // 'url:url',
            // 'created_at',
            // 'created_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '<div class="btn-group btn-group-sm text-center"
role="group">{delete} {update}&nbsp;{addSub}&nbsp;{view}</div> ',
                'options' => ['style' => 'width:120px;'],
                'buttons' => [
                    'addSub' => function ($url, $model) {
                        return Html::a('<i class="fa fa-plus"></i>',
                            ["add-submenu", 'parent' => $model->id]
                            , ['class' => 'btn btn-default']);
                    }
                ],

            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>

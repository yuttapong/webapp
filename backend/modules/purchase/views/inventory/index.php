<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\modules\purchase\models\Inventory;
use yii\web\JsExpression;
use kartik\editable\Editable;
use kartik\sidenav\SideNav;

\backend\modules\purchase\InventoryAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\purchase\Models\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$categoryName = '';
$this->title = 'Inventory';

if($category){
    $categoryName =  ' > '.$category->name;
}

$this->params['breadcrumbs'][] = $this->title . $categoryName;
$currentAction = Yii::$app->controller->action->id;
?>

<div class="row">
    <div class="col-xs-12 col-sm-3 col-md-3">
        <?php
        $type = SideNav::TYPE_INFO;
        $item = Yii::$app->controller->id;
        echo SideNav::widget([
            'type' => SideNav::TYPE_DEFAULT,
            'encodeLabels' => false,
            'heading' => 'Category',
            'items' =>  \backend\modules\purchase\models\Categories::getSidebarItem(),
        ]);
        ?>
    </div>
    <div class="co-xs-12 col-sm-9 col-md-9">

        <div class="pull-left"> <?= Html::a('<i class="fa fa-home"></i> แสดงทั้งหมด', ['index'], ['class' => 'btn btn-link']) ?></div>
        <div class="pull-right">
            <div class="btn-group">
                <?php
                \yii\bootstrap\Modal::begin([
                    'options' => [
                        'id' => 'modal-customer',
                    ],
                    'toggleButton' => [
                        'label' => '<i class="fa fa-search"></i> ค้นหา',
                        'class' => 'btn btn-default'
                    ],
                    'closeButton' => [
                        'label' => 'Close',
                        'class' => 'btn btn-danger btn-sm pull-right',
                    ],
                    'size' => 'modal-lg',
                    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]

                ]);
                ?>
                <?php  $this->render('_search', ['model' => $searchModel]); ?>
                <?php
                \yii\bootstrap\Modal::end();

                ?>

                <?= Html::a('<i class="fa fa-plus"></i> เพิ่มสินค้าใหม่', ['create'], ['class' => 'btn btn-default']) ?>

            </div>
        </div>

        <div class="clearfix"></div>
        <div class="well well-md">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>

        <?php
        if($category){
           echo Html::tag('h3',  $category->name);
        }
        ?>
        <?php
        $gridColumns = [
            // ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Inactive',
                    1 => 'Active'
                ],
                'value' => function ($model) {
                    return ($model->status == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger']);
                }
            ],
            [
                'header' => 'Photo',
                'format' => 'raw',
                'value' => function ($model) {
                    if($model->file_id){
                        return Html::a(Html::img($model->imageThumbnailUrl, ['width' => 120]), $model->imageUrl, [
                            'class' => $model->file_id?'lightbox':'',
                            'title' => $model->name,
                            'alt' => $model->name
                        ]);
                    } else {
                        return Html::img($model->imageThumbnailUrl, ['width' => 120]);
                    }
                },
                'options' => [
                    'style' => 'width:150px;'
                ]
            ],
            [
                'attribute' => 'code',
                'value' => function ($model) {
                    return !empty($model->code) ? Html::tag('button', $model->code, [
                        'class' => 'btn btn-default btn-block',
                        'style' => 'font-size:14px;font-weight:bold'
                    ]) : '';
                },
                'format' => 'raw',
                'options' => [

                ]
            ],
            'id',
            'name',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'master_id',
                'pageSummary' => false,
                'readonly' => false,
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->master_id != '') {
                        return $model->master_id . '  :  ' . $model->inventory->name;
                    } else {
                        return null;
                    }

                },
                'editableOptions' => function ($model, $key, $index) {

                    $url = \yii\helpers\Url::to(['inventory/inventory-list', 'id' => $model->master_id]);
                    $cityDesc = empty($model->master_id) ? '' : $model->master_id . ':' . Inventory::findOne($model->master_id)->name;
                    return [
                        'header' => 'Search for master product',
                        'size' => 'md',
                        'name' => 'master_id',
                        //   'format' => Editable::FORMAT_BUTTON,
                        'inputType' => Editable::INPUT_SELECT2,
                        'asPopover' => false,
                        'options' => [
                            'initValueText' => $cityDesc,
                            'pluginOptions' => [
                                'allowClear' => true,
                                'minimumInputLength' => 2,
                                'ajax' => [
                                    'url' => $url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                                ],
                            ],

                        ]


                    ];
                }

            ],
            'unit_name',
            ['class' => 'yii\grid\ActionColumn'],


        ];


        echo GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => $gridColumns,
            'pjax' => true,


        ]);
        ?>


</div>
</div>

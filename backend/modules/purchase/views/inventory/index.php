<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\modules\purchase\models\Inventory;
use yii\web\JsExpression;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\purchase\Models\InventorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventories';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inventory-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Inventory', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $gridColumns = [
        // ['class' => 'kartik\grid\SerialColumn'],
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
                    'header' => '&nbsp;',
                    'size' => 'md',
                    'name' => 'master_id',
                    'inputType' => Editable::INPUT_SELECT2,
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


        [
            'class' => 'kartik\grid\BooleanColumn',
            'attribute' => 'status',
            'vAlign' => 'middle',
        ],
        ['class' => 'yii\grid\ActionColumn'],


    ];


    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        // 'pjax'=>true,


    ]);
    ?>
</div>

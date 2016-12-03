<?php

use yii\helpers\Html;

use kartik\editable\Editable;
use kartik\grid\GridView;
use yii\web\JsExpression;
use common\models\Customers;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\models\HomeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Homes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'project.name',
          'plan_no',
            [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'home_no',
            'format' => 'raw', 
            'editableOptions' => function ($model, $key, $index) {
            	return [
            			'header' => '&nbsp;',
            			'size' => 'md',
            			'placement' => GridView::ALIGN_LEFT, 
            			'inputType'=> Editable::INPUT_TEXT   , 
            	];
            }
            ],
            [
           // 'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'date_insurance',
            'format' => 'raw',
            'value'=> function($data) {
            $text=  $data->date_insurance!=''?date ( "d-m-Y", $data->date_insurance):'' ;
            		return $text;
            },
           /* 'editableOptions' => function ($model, $key, $index) {
            //$model->date_insurance='ddd';
            	return [
            			'header' => '&nbsp;',
            			'size' => 'md',
            			'placement' => GridView::ALIGN_LEFT,
            			'value'=>'dd',
            			'inputType'=> Editable::INPUT_DATE    ,
            
            	];
            }*/
            ],
            [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'customers_id',
            'pageSummary' => true,
            'readonly' => false,
            'format' => 'raw',
            'value' => function ($model) {
            	if($model->customers_id !=''){
            		return $model->customers_name;
            	}else {
            		return null;
            	}
            
            },
            'editableOptions' => function ($model, $key, $index) {
            	 
            	$url = \yii\helpers\Url::to(['home/customers-list','id'=>$model->customers_id]);
            	$cityDesc='';
            	if(!empty($model->customers_id)){
            		$mCus =Customers::findOne($model->customers_id);
            		$cityDesc = $mCus->prefixname.' '.$mCus->firstname.' '.$mCus->lastname;
            	}
            	
            	return [
            			'header' => '&nbsp;',
            			'size' => 'md',
            			'placement' => GridView::ALIGN_LEFT,
            			'name' => 'customers_id',
            			'inputType'=> Editable::INPUT_SELECT2,
            			'options'=>[
            					'initValueText' =>$cityDesc,
            					
            					'pluginOptions'=>[
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
            // 'status',
            // 'type',
            // 'home_prices',
            // 'land',
            // 'use_area',
            // 'home_status',
            // 'compact_status',
            // 'transfer_status',
            // 'created_at',
            // 'created_by',
            // 'date_insurance',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

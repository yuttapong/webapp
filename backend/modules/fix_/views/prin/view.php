<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;
use backend\modules\org\models\OrgApprove;
use backend\modules\recruitment\models\RcmApproverUser;
use backend\modules\recruitment\models\RcmAppManpower;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\Prin */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Prins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prin-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'code',
            'title',
            'description:ntext',
            'type',
            'user_order_id',
            'site_id',
            'project_id',
        ],
    ]) ?>

</div>
<?php 
$option['approver_user_id']='133';
$option['company_id']=3;
$option['site_id']=1;
$option['level']=0;
$option['user_id']=133;
$option['document_id']=1;

$config = [
		'table_main' => RcmApproverUser::tableName(),
		'table_name' => RcmAppManpower::CODE_TABLE_NAME,
		'ref_id' => 2,
		'document_id' => 1,
		'company_id' => 3,
		'site_id' => 1,
		'user_id' => 133,
		'approver_user_id' => 133,
		//  '_type' => SysDocumentOption::TYPE_ORGANIZATION,
];

//ข้อมูลรายชื่อผู้ที่จะอนุมัติและอนุมัติไปแล้ว
$listApprove = OrgApprove::getListApprove($config);

echo '<pre>';
print_r($listApprove);
echo '</pre>';

?>
รายการวัสดุที่<br>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn',
            	'options' => ['class' => 'icheckbox_minimal',]
            ],
            'prin_id',
            'inventory_name',
            'qty',
            [
            'header'=>'หน่วย',
            'format' => 'raw',
            'value'=> function($data) {
	            $check=0;
	            if($data->inventory_id!=''){
		           // if($data->inventory->unit_id==$data->unit_id && $data->inventory->name ==$data->inventory_name){
		           // 	$check=1;
		           // }
	            }
	            	return  $data->unit->name;
            },
            ],
          
            'home_id',
            'job_name',
            [
            'headerOptions' => ['style' => 'background-color:#ccf8fe'],
            'attribute' => 'inventory.name',
            
            ],
            [
            'headerOptions' => ['style' => 'background-color:#ccf8fe'],
            'attribute' => 'unitBuy.name',
            
            ],
            [
            	'headerOptions' => ['style' => 'background-color:#ccf8fe'],
            	'attribute' => 'inventoryPrice.price',
            		
            ],
            [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'is_confirm',
            		'headerOptions' => ['style' => 'background-color:#ccf8fe'],
            'format' => 'raw',
            'value'=> function($data) {
            	return  $data->is_confirm?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>';
            },
            'editableOptions' => function ($model, $key, $index) {
            	return [
            			'header' => '&nbsp;',
            			'size' => 'md',
            			'placement' => GridView::ALIGN_LEFT,
            			'name' => 'is_confirm',
            			'value' => $model->is_confirm,
            			'inputType'=> Editable::INPUT_SWITCH  ,
            			 
            	];
            }
            ],
            [
            'header'=>'ร้านซื้อ',
            'format' => 'raw',
            'headerOptions' => ['style' => 'background-color:#ccf8fe'],
            'value' => function ($data) {
        
            	return  @$data->vendor->company;
            },
            ], 
         
            [
		             'header'=>'เปลี่ยนร้าน',
            		'headerOptions' => ['style' => 'background-color:#ccf8fe'],
		            'format' => 'raw',
		            'value' => function ($data) {
		            $url=Url::to(['prin/show-vendor','id'=>$data->id,'view'=>'pr-to-po' ]);
		          
		            
		            return  Html::button('edit', [ 'class' => 'btn btn-primary','id'=>'xxx', 'onclick' =>"loadInventery('$url');return true;" ]);
		            },
            ],
        ],
    ]); ?>


<?php 
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<?php  $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?php
$check=(isset($_GET['PrinDetailSearch']['vendor_id']) && $_GET['PrinDetailSearch']['vendor_id'] !='');

if($check){
	?>
	
	<?= $form->field($modelPoin, 'site_id')->textInput() ?>
	   <div class="form-group">
        <?= Html::submitButton( 'เปิด po', ['class' => 'btn btn-success']) ?>
    </div>
    
	<?php 
}

?>


   
<div class="row">
 <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            [
            	'class' => 'kartik\grid\CheckboxColumn',
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
	           	 $html=Html::hiddenInput('PoinDetail['.$data->id.'][prin_id]' , $data->prin_id);
	           	 $html .=Html::hiddenInput('PoinDetail['.$data->id.'][inventory_id]' , $data->inventory_id);
	           	 $html .=Html::hiddenInput('PoinDetail['.$data->id.'][inventory_price_id]' , $data->inventory_price_id);
	           	 $html .=Html::hiddenInput('PoinDetail['.$data->id.'][vendor_id]' , $data->vendor_id);
	            	return  $data->unit->name.$html;
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
            'class'=>'kartik\grid\BooleanColumn',
            'attribute'=>'is_confirm',
            'vAlign'=>'middle',
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

</div>	
   <?php ActiveForm::end(); ?>	            
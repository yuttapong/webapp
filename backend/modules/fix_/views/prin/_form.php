<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use kartik\widgets\Select2;
use common\widgets\dynamicform\DynamicFormWidget;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use common\widgets\autocompleteAjax\AutocompleteAjax;
use backend\modules\purchase\models\Unit;
use yii\helpers\ArrayHelper;
use common\models\Home;

$data = [
		"red" => "red",
		"green" => "green",
		"blue" => "blue",
		"orange" => "orange",
		"white" => "white",
		"black" => "black",
		"purple" => "purple",
		"cyan" => "cyan",
		"teal" => "teal"
];
$dataUnit=ArrayHelper::map(Unit::find()->all(), 'id', 'name');
$dataHome=[];
foreach (Home::find()->all() as $val ){
	$dataHome[$val->id]=$val->plan_no;

	
}
?>

<div class="prin-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php //= $form->field($model, 'type')->textInput() ?>
    <?= $form->field($model, 'user_order_id')->textInput() ?>
    <?= $form->field($model, 'site_id')->textInput() ?>
    <?= $form->field($model, 'project_id')->textInput() ?>

     <?php
     
      DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $modelInven[0],
        'formId' => 'dynamic-form',
        'formFields' => [
	        'inventory_name',
	         'unit_id',
	          'qty',
        ],
    ]); ?>
		<table class="table table-bordered table-striped" border="1">
		        <thead>
		            <tr>
		                <th width="40%">ชื่่อวัสดุ</th>
		                <th>จำนวน</th>
		                <th>หน่วย</th>
		                <th>แปลงบ้าน</th>
		                <th>งาน</th>
		                <th class="text-center" style="width: 90px;">
		                    <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
		                </th>
		            </tr>
		        </thead>
		        <tbody class="container-items">
		        <tr class="house-item hide">
		         <td class="vcenter">
		         <!-- input type="hidden" id="inv_check_0" class="check" name="inv[check][0]" value=""-->
		                <?php  
		                echo '<input type="hidden" id="inv_check_0" name="inv[check][0]" value="" class="mainkey">';
		                /*   echo AutocompleteAjax::widget([
								'attribute'=>'inventory_id',
		         		  		'main_id'=>'[0]inventory_id',
		                   		'main_name'=>'PrinDetail[0][inventory_name]',
		                   		'model'=>$modelInven[0],
		                   		'multiple' => false,
		                   		'url' => ['prin/search-user'],
		                   		'options' => ['placeholder' => 'วัสดุ','id'=>'prindetail-0-inventory_name']
		                   		]);
		                   */
		                echo $form->field($modelInven[0],"inventory_id" )->widget(AutocompleteAjax::classname(), [
		                		'type'=>'key_name',
		                		'attribute_name'=>'inventory_name',
		                		'rowIndex'=>0,
		                		'multiple' => true,
		                		'url' => ['prin/search-user'],
		                		'options' => ['placeholder' => 'วัสดุ','id'=>'prindetail-0-inventory_name'
		                		,'onkeyup'=>'autocomplet_ajax(this,"inventory_id")']
		                ])->label(false);
		                   ?> 
		                </td>
		                 <td class="vcenter"> 
		                 <?php echo  $form->field($modelInven[0], "[0]qty")->label(false)->textInput(['maxlength' => true]) ?>
		                  </td>
		                 <td class="vcenter">
		         		  <?php  
		         		
		         		  echo $form->field($modelInven[0], "[0]unit_id")->widget(Select2::classname(), [
		         		  		'data' => $dataUnit,
		         		  		'options' => ['placeholder' => 'Select a state ...'],
		         		  		'pluginOptions' => [
		         		  				'allowClear' => true
		         		  		],
		         		  ])->label(false);
		         		   ?>
		                 </td>
		                 <td class="vcenter">
		                   <?php
		                   echo $form->field($modelInven[0], "[0]home_id")->widget(Select2::classname(), [
		                   		'data' => $dataHome,
		                   		'options' => ['placeholder' => 'Select a state ...'],
		                   		'pluginOptions' => [
		                   				'allowClear' => true
		                   		],
		                   ])->label(false);
		                   ?> 
		                 </td>
		                 <td class="vcenter">
		                 <?php 
		            
		                 echo $form->field($modelInven[0],"job_list_id" )->widget(AutocompleteAjax::classname(), [
		                 		'type'=>'key_name',
		                 		'attribute_name'=>'job_name',
		                 		'rowIndex'=>0,
		                 		'multiple' => true,
		                 		'url' => ['prin/search-user'],
		                 		'options' => ['placeholder' => 'วัสดุ','id'=>'prindetail-0-job_name'
		                 		,'onkeyup'=>'autocomplet_ajax(this,"job_list_id")'
		                 		]
		                 ])->label(false);
		                   
		                   ?> 
		                </td>
		                <td class="text-center vcenter" style="width: 90px; verti">
		                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
		                </td>
		        </tr>
		        <?php  
		        $hidd_ck='';
		        foreach ($modelInven as $indexHouse => $modelHouse): 
		       			 $rowIndex=$indexHouse+1;
		        		 $ck_text='';
		                    if($modelHouse->id!=''){
		                    	$ck_text='edit';
		                    	  $hidd_ck .='<input type="hidden" id="inv_key_'.$rowIndex.'" name="inv[key]['.$rowIndex.']" value="'.$modelHouse->id.'">';
		                    }
		      			 	 $hidd_ck .='<input type="hidden" id="inv_check_'.$rowIndex.'" name="inv[check]['.$rowIndex.']" value="'.$ck_text.'">';
		      			
		      		?>
		            <tr class="house-item">
		                <td class="vcenter">
		                    <?php 
		                        if (! $modelHouse->isNewRecord) {
		                            echo Html::activeHiddenInput($modelHouse, "[{$rowIndex}]id");
		                        }
		                    ?>
		                    <?php 

		              
		                    echo $form->field($modelHouse,"inventory_id" )->widget(AutocompleteAjax::classname(), [
		                    	'type'=>'key_name',
		                    	'attribute_name'=>'inventory_name',
		                    	'rowIndex'=>$rowIndex,
							    'multiple' => true,
							    'url' => ['prin/search-user'],
		                    	'options' => ['placeholder' => 'วัสดุ','id'=>'prindetail-'.$rowIndex.'-inventory_name'
		                    	,'onkeyup'=>'autocomplet_ajax(this,"inventory_id")'
		                    	]
							])->label(false);
		                    ?>
		                </td>
		                 <td class="vcenter">
		                   <?= $form->field($modelHouse, "[{$rowIndex}]qty")->label(false)->textInput(['maxlength' => true]) ?>
		                 </td>
		         		<td class="vcenter">
		         		  <?php
		         		
		         		  echo $form->field($modelHouse, "[$rowIndex]unit_id")->widget(Select2::classname(), [
		         		  		'data' => $dataUnit,
		         		  		'options' => ['placeholder' => 'Select a state ...'],
		         		  		'pluginOptions' => [
		         		  				'allowClear' => true
		         		  		],
		         		  ])->label(false);
		         		   ?>
		                 </td>
		                 <td class="vcenter">
		                  <?php
		         		
		         		  echo $form->field($modelHouse, "[{$rowIndex}]home_id")->widget(Select2::classname(), [
		         		  		'data' => $dataHome,
		         		  		'options' => ['placeholder' => 'Select a state ...'],
		         		  		'pluginOptions' => [
		         		  				'allowClear' => true
		         		  		],
		         		  ])->label(false);
		         		   ?> 
		                 </td>
		                 <td class="vcenter">
		                 <?php 
		          
		                 echo $form->field($modelHouse,"job_list_id" )->widget(AutocompleteAjax::classname(), [
		                 		'type'=>'key_name',
		                 		'attribute_name'=>'job_name',
		                 		'rowIndex'=>$rowIndex,
		                 		'multiple' => true,
		                 		'url' => ['prin/search-user'],
		                 		'options' => ['placeholder' => 'วัสดุ','id'=>'prindetail-'.$rowIndex.'-job_name'
		                 		,'onkeyup'=>'autocomplet_ajax(this,"job_list_id")'
		                 		]
		                 ])->label(false);
		                 ?>
		                 </td>
		                <td class="text-center vcenter" style="width: 90px; verti">
		                    <button type="button" class="remove-house btn btn-danger btn-xs" data-id="inv_check_<?=$rowIndex?>" ><span class="fa fa-minus"></span></button>
		                </td>
		            </tr>
		         <?php endforeach;  ?>
		        </tbody>
		    </table>
    <?php DynamicFormWidget::end();
	echo $hidd_ck;
    ?>
    
    
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

      
    <?php ActiveForm::end(); ?>

</div>

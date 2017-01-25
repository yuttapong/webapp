<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use common\models\Project;
use yii\helpers\ArrayHelper;
use kartik\widgets\DepDrop;
use kartik\datetime\DateTimePicker;
use common\widgets\dynamicform\DynamicFormWidget;
use common\widgets\autocompleteAjax\AutocompleteAjax;
use kartik\file\FileInput;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFix */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord){
	$model->date_inform=date ( "d-m-Y H:i", time());
}
?>

<div class="inform-fix-form">

    <?php $form = ActiveForm::begin(['options'=>['onsubmit'=>'  $(\'input\').removeAttr("disabled")'
    		,'id' => 'dynamic-form','enctype' => 'multipart/form-data']]); ?>
    <input id="check-customs" class="form-control" name="customer_id" type="hidden" value="">
    <?= $form->field($model, 'customer_id')->hiddenInput(['placeholder'=>'รหัสลูกค่า'])->label(false) ?>
    <div class="row">
       <div class="col-sm-4 col-md-4">
        <?= $form->field($model, 'project_id')->dropdownList(
            ArrayHelper::map(Project::find()->all(),
            'id',
            'name'),
            [
                'id'=>'ddl-project',
                'prompt'=>'--เลือกโครงการ--'
       ]); ?>
       </div>
       <div class="col-sm-4 col-md-4">
       <?= $form->field($model, 'home_id')->widget(DepDrop::classname(), [
       		'type'=>DepDrop::TYPE_SELECT2,
       		'select2Options' => ['pluginOptions'=>['allowClear'=>true]],
            'options'=>['id'=>'ddl-home',
            		'data-urlc'=>Url::to(['/fix/inform-fix/data-customer']),
            	'onchange'=>	'if(this.value!=""){ 
            		$.ajax({
							url: this.getAttribute(\'data-urlc\'),
							type: "GET",
							data: {id:this.value},
							success:function(data){ 
            				item=JSON.parse(data);
	            			if(item.id!=\'\'){
	            				$(\'#informfix-customer_id\').val(item.id);
	            				$(\'#informfix-telephone\').val(item.mobile);
	    						$(\'#informfix-customer_name\').val(item.value);
	    						$(\'#informfix-prefixname\').val(item.prefixname);
	    						$(\'#informfix-prefixname\').attr("disabled", true);
	    						$(\'#informfix-customer_name\').attr("disabled", true);
	            				$(\'#check-customs\').val(\'old\');
	    						$(\'#comtoms\').html(\'<span class="label label-primary">ลูกค้าเก่า</span>\');
	            			}else{
            					$(\'#informfix-customer_id\').val("");
	            				$(\'#informfix-telephone\').val("");
	    						$(\'#informfix-customer_name\').val("");
	    						$(\'#informfix-prefixname\').val("");
            				}
							}
						}); 
			}',
            		
       ],
            'data'=> $modelhome,
            'pluginOptions'=>[
            		
                'depends'=>['ddl-project'],
                'placeholder'=>'---แปลงบ้าน--',
                'url'=>Url::to(['/home/get-home'])
            ],

        ]); ?>
    </div>
     <div class="col-sm-4 col-md-4">
        <?= $form->field($model, 'date_inform')->widget(DateTimePicker::classname(), [
        		'type' => DateTimePicker::TYPE_INPUT,
        		'language' => 'th',
			    'options' => ['placeholder' => 'Enter event time ...'],
					'pluginOptions' => [
					'format' => 'dd-mm-yyyy hh:ii',
						'autoclose' => true,
						'allowClear' => true,
					]
			]);
?> 
        
          </div>
	</div>
   <div class="row">
   
   <div class="col-md-3">
    <div class="input-group"> 
                 <?php 
    echo Typeahead::widget([
    		'name' => 'searching',
    		'options' => ['placeholder' => 'พิมพ์ค้นหา ลูกค้า...','id'=>'name-text'],
    		'pluginOptions' => ['highlight'=>true],
    		'dataset' => [
    				[
    							'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                			'display' => 'show',
                			'remote' => [
                				'url' => Url::to(['/fix/inform-fix/customer-list']) . '?q=%QUERY',
                				'wildcard' => '%QUERY'
    						]
    				]
    		],
    		'pluginEvents' => [
    				"typeahead:select" => 'function(index,item){
    					$(\'#informfix-customer_id\').val(item.id);
    					$(\'#informfix-customer_name\').val(item.value);
    					$(\'#informfix-prefixname\').val(item.prefixname);
    					$(\'#informfix-prefixname\').attr("disabled", true);
    					$(\'#informfix-customer_name\').attr("disabled", true);
                     	 $(this).typeahead(\'val\',\'\');
    				$(\'#check-customs\').val(\'old\');
    				$(\'#comtoms\').html(\'<span class="label label-primary">ลูกค้าเก่า</span>\');
                      }', ]
    ]);
    ?>
     <span class="input-group-btn">
                 <?=Html::button('+',['class'=>'add-res btn btn-success','onclick' => '
			if($(\'#name-text\').val()!=\'\'){
			$(\'#informfix-customer_name\').val($(\'#name-text\').val());
			$(\'#informfix-customer_name\').removeAttr(\'disabled\');
			$(\'#informfix-prefixname\').removeAttr(\'disabled\');
			$(\'#informfix-prefixname\').val(\'\');
			$(\'#informfix-customer_id\').val(\'\');
			$(\'#informfix-customer_id\').addClass("hide"); 
			$(\'#comtoms\').html(\'<span class="label label-success">ลูกค้าใหม่</span>\');
			$(\'#name-text\').val(\'\');
			$(\'#check-customs\').val(\'new\');
}
		'])?>
                </span>
            </div>
   
   </div>
<div class="col-md-1"> 
   <?= $form->field($model, 'prefixname')->textInput(['placeholder'=>'คำนำหน้า','disabled'=>true]) ?>
   </div>
   <div class="col-md-3">
   
    <?= $form->field($model, 'customer_name')->textInput(
    		[  'onchange'=>'
    				$(\'#informfix-customer_id\').val(\'\'); ',
    				'placeholder'=>'ชื่อ-สกุล'
    				,'disabled'=>true
    ]
    		) ?>
   </div>
   <div class="col-md-2"> 
    <?= $form->field($model, 'telephone')->widget(\yii\widgets\MaskedInput::className(), [	
    'mask' => '999-999-9999',
]) ?>
   </div>
  <div class="col-md-2"> 
        <?= $form->field($model, 'date_modify')->widget(DateTimePicker::classname(), [
        		'type' => DateTimePicker::TYPE_INPUT,
        		'language' => 'th',
			    'options' => ['placeholder' => 'Enter event time ...'],
					'pluginOptions' => [
					'format' => 'dd-mm-yyyy hh:ii',
						'autoclose' => true,
						'allowClear' => true,
					]
			]);
?> 
        
    
      <span id="comtoms hide" ></span>
   
   </div>
   
     </div>
     
    
    <?php
     
      DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => 50,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $modelJob[0],
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
		                <th >ปัญหาที่พบ/รายละเอียดที่ต้องการให้แก้ไข</th>
		             
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
		            	echo $form->field($modelJob[0],"job_list_id" )->widget(AutocompleteAjax::classname(), [
		                 		'type'=>'key_name',
		                 		'attribute_name'=>'list',
		                 		'rowIndex'=>0,
		                 		'multiple' => true,
		                 		'url' => ['inform-fix/job-list'],
		                 		'options' => ['placeholder' => 'ปัญหาที่พบ','id'=>'informjob-0-list'
		                 				,'onkeyup'=>'autocomplet_ajax(this,"job_list_id")']
		                 ])->label(false);
		            
		                   ?> 
		                </td>
		            
		                <td class="text-center vcenter" style="width: 90px; verti">
		                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
		                </td>
		        </tr>
		        <?php  
		        $hidd_ck='';
		        foreach ($modelJob as $indexHouse => $modelHouse): 
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

		              
		                    echo $form->field($modelHouse,"job_list_id" )->widget(AutocompleteAjax::classname(), [
		                    	'type'=>'key_name',
		                    	'attribute_name'=>'list',
		                    	'rowIndex'=>$rowIndex,
							    'multiple' => true,
							    'url' => ['inform-fix/job-list'],
		                    	'options' => ['placeholder' => 'ปัญหาที่พบ','id'=>'informjob-'.$rowIndex.'-list'
		                    	,'onkeyup'=>'autocomplet_ajax(this,"job_list_id")',
		                    
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
    <div class="form-group field-upload_files">
  <label class="control-label" for="upload_files[]"> อัพโหลดไฟล์ต่างๆ </label>
<div>
<?= FileInput::widget([
               'name' => 'upload_files[]',
               'options' => ['multiple' => true], //'accept' => 'image/*' หากต้องเฉพาะ image
                'pluginOptions' => [
                    'overwriteInitial'=>false,
                    'initialPreviewShowDelete'=>true,
                    'initialPreview'=> $initialPreview,
                    'initialPreviewConfig'=> $initialPreviewConfig,
                    'previewFileType' => 'any',
                    'uploadUrl' => Url::to(['inform-fix/upload']),
                    'uploadExtraData' => [
                        'request_id' => $model->id,
                    ],
                    'maxFileCount' => 100
                ]
            ]);
            ?>
</div>
</div>
    
    <?php
if($model->type==''){
	$model->type=2;
}
;
echo  $form->field($model, 'type',[
		'inputOptions'=>[
				'class'=>'form-control hide',
			
		]
		
		]) ->dropDownList(
          $model->getTypeItems(),
          ['prompt'=>'--ประเภทผู้แจ้ง--','id'=>'type']    
        )->label(false)  ?>
<?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


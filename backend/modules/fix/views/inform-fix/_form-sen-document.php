<?php 
use yii\bootstrap\ActiveForm;
use common\widgets\dynamicform\DynamicFormWidget;
use common\widgets\autocompleteAjax\AutocompleteAjax;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use backend\modules\org\models\OrgPersonnel;
use common\widgets\AjaxSubmitButton;
use yii\helpers\Url;
use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;




$dataPresonnel=[];
foreach (OrgPersonnel::find()->where(['active'=> 1,'user_id'])
		->where('active =:active AND user_id <> \'\' ', [':active' =>1])
		->all() as $val ){
	$dataPresonnel[$val->user_id]=$val->prefix_name_th.' '.$val->firstname_th.' '.$val->lastname_th.'( '.$val->nickname.' )' ; 
}
?>
<div class="prin-form">
<?php
 $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
  <?php 
				 $url=Url::to(['inform-fix/send-user','id'=>$id]);
				 AjaxSubmitButton::begin([
				 'label'=>'ส่งงาน',
				 'ajaxOptions'=>
				 [
				 'type'=>'POST',
				 'url'=> $url,
				 'cache' => false,
				 'beforeSend'=> new \yii\web\JsExpression('function() {  var r = confirm("ยืนยันการส่งข้อมูล");   if(!r){return false;}   }'),
				 'success' => new \yii\web\JsExpression('function(html){ 
		    		if(html=="1"){
    					$(\'#modal\').modal(\'hide\');
						 $.pjax.reload({container:"#p-inform-fixes"});
		    		}else{
				 			$("#modal .modal-body").html(html);
		    		}
                }') ,
           
                 ],
                 'options' => ['type' => 'submit','id'=>'login-formx'],
                 ]);
                 AjaxSubmitButton::end();
 ?>
  
   <?php
     
      DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $model[0],
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
		                <th width="40%">ซื้อผู้แจ้ง</th>
		                <th>เพิ่มเติ่ม</th>
		                
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
		                   ?> 
		                   <?php
		         		
		         		  echo $form->field($model[0], "[0]recipient_user_id")->widget(Select2::classname(), [
		         		  		'data' => $dataPresonnel,
		         		  		'options' => ['placeholder' => 'Select a state ...'],
		         		  		'pluginOptions' => [
		         		  				'allowClear' => true
		         		  		],
		         		  ])->label(false);
		         		   ?> 
		                </td>
		                 <td class="vcenter"> 
		               <?= $form->field($model[0], '[0]title')->textInput(['maxlength' => true])->label(false) ?>
		                  </td> 
		                <td class="text-center vcenter" style="width: 90px; verti">
		                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
		                </td>
		        </tr>
		        <?php  
		        $hidd_ck='';
		        foreach ($model as $indexHouse => $modelHouse): 
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
		         		
		         		  echo $form->field($modelHouse, "[{$rowIndex}]recipient_user_id")->widget(Select2::classname(), [
		         		  		'data' => $dataPresonnel,
		         		  		'options' => ['placeholder' => 'Select a state ...'],
		         		  		'pluginOptions' => [
		         		  				'allowClear' => true
		         		  		],
		         		  ])->label(false);
		         		   ?> 
		                </td>
		                 <td class="vcenter"> 
		                 <?= $form->field($modelHouse, "[{$rowIndex}]title")->textInput(['maxlength' => true])->label(false) ?>
		                 </td> 
		                <td class="text-center vcenter" style="width: 90px; verti">
		                    <button type="button" class="remove-house btn btn-danger btn-xs" data-id="inv_check_<?=$rowIndex?>" ><span class="fa fa-minus"></span></button>
		                </td>
		            </tr>
		         <?php endforeach;  ?>
		        </tbody>
		    </table>
		    <div class="row">
		     <div class="col-sm-3 col-md-3">
		    	 <?php 
			    echo Html::dropDownList('checkSen',1,['1' => 'ส่ง Email', '0' => 'ไม่ส่ง Email '])
			    ?>
		     </div>
		      <div class="col-sm-1 col-md-1"><strong>เรื่อง</strong></div>
		     <div class="col-sm-8 col-md-8">
		      	<?= Html::textInput('subject',"แจ้งซ่อม เลขที่  ".$modelMain->code,['class'=>'form-control']); ?>
		     </div>
		        
		   
		    </div>
		    <div class="row"><strong>รายละเอียด</strong></div>
		 	<div class="row">
		 	<?php 
		 	$text='';
		 	if(count($modelMain->informJobs)>0){
		 		$i=1;
		 		$text.='รายละเอียดงาน <br>';
		 		foreach ($modelMain->informJobs as $val){
		 			$text.=$i.' '.$val->list.'<br>';
		 	
		 	
		 			$i++;
		 		}
		 	}

		 	?>
		    <?= Html::textarea('content',str_replace('<br>', PHP_EOL,$text),['class'=>'form-control','rows' => 5]); ?>

		     </div>
    <?php DynamicFormWidget::end();
		echo $hidd_ck;
    ?>
  <?php ActiveForm::end(); ?>
  <?php 
  if(count($modelMain->sendDocumentsl)>0){
  	$i=1;
  	foreach ($modelMain->sendDocumentsl as $val){
  		$text='<span class="bg-danger" >ยังไม่่รับทราพ</span>';
  		if( $val->is_khow==1){
  			$text='<span class="bg-success" >รับทราพแล้ว</span>';
  		}
  		
  		echo $i.'. '. $val->recipient_user_name.'   '.$text.'<br>';
  		$i++;
  	}
  	
  }

  
  ?>
</div>
<?php 
use yii\bootstrap\ActiveForm;

use kartik\date\DatePicker;
use common\widgets\AjaxSubmitButton;
use yii\helpers\Url;

?>
<div class="prin-form">
<?php
 $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
 <?php 
				 $url=Url::to(['inform-fix/send-date-insurance','id'=>$model->id]);
				 AjaxSubmitButton::begin([
				 'label'=>'บันทึกข้อมูล',
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
    <?= $form->field($model, 'date_insurance')->widget(DatePicker::classname(), [
        		'type' => DatePicker::TYPE_INPUT,
			    'options' => ['placeholder' => 'Enter event time ...'],
					'pluginOptions' => [
					'format' => 'dd-mm-yyyy',
						'autoclose' => true,
						'allowClear' => true,
					]
			]);
?> 
  <?php ActiveForm::end(); ?>
 
</div>
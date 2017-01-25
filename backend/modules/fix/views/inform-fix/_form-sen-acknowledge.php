<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\widgets\AjaxSubmitButton;
use kartik\grid\GridView;
$option=unserialize($modelSen->option);
?>
<div class="prin-form">
<?php
 $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
   <?php 
				 $url=Url::to(['send-documents/send-acknowledge','id'=>$modelSen->id]);
				 AjaxSubmitButton::begin([
				 'label'=>'บันทึก',
				 'ajaxOptions'=>
				 [
				 'type'=>'POST',
				 'url'=> $url,
				 'cache' => false,
				 'beforeSend'=> new \yii\web\JsExpression('function() {  var r = confirm("ยืนยันการส่งข้อมูล");   if(!r){return false;}   }'),
				 'success' => new \yii\web\JsExpression('function(html){ 
				 		
		    		if(html=="1"){
    					$(\'#modal\').modal(\'hide\');
						history.back();
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
if($modelSen->is_khow==''){
	$modelSen->is_khow = '1';
}
echo $form->field($modelSen, 'is_khow')->radioList([1 => 'รับทราบ', 2 => 'ไม่เเกี่ยวข้อง'])->label();?>
<?php 

$text_khow='';
if(!empty($option['text_khow'])){
	$text_khow=$option['text_khow'];
}

?>
 <?= $form->field($modelSen, 'option[text_khow]')->textArea(['rows' => '2', 'value' =>$text_khow]) ?>
 
  <?php ActiveForm::end(); ?>
  
</div>

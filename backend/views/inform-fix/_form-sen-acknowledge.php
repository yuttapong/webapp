<?php 
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\widgets\AjaxSubmitButton;
use kartik\grid\GridView;
use yii\helpers\Html;


$option=unserialize($modelSen->option);
?>

<div class="prin-form">
<?php
 $form = ActiveForm::begin(['id' => 'dynamic-form']);
 echo Html::hiddenInput('user_id', $user_id);
 
 ?>
 <?= $form->field($modelSen, 'password')->passwordInput()->label('รหัสอนุมัติ'); ?>
   <?php 
				 $url=Url::to(['inform-fix/save-doc','id'=>$modelSen->id]);
				 AjaxSubmitButton::begin([
				 'label'=>'บันทึก',
				 'ajaxOptions'=>
				 [
				 'type'=>'POST',
				 'url'=> $url,
				 'cache' => true,
				 'beforeSend'=> new \yii\web\JsExpression('function() {  var r = confirm("ยืนยันการส่งข้อมูล");   if(!r){return false;}   }'),
				 'success' => new \yii\web\JsExpression('function(html){ 
				 		
		    		if(html=="1"){
    					$(\'#modal_fd\').modal(\'hide\');
 						$.pjax.reload({container:"#fdcountries"});
						history.back();
		    		}else{
				 			$("#modal_fd .modal-body").html(html);
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
echo $form->field($modelSen, 'is_khow')->radioList([1 => 'รับทราบ', 2 => 'เสนอแนะ'])->label();?>
<?php 

$text_khow='';
if(!empty($option['text_khow'])){
	$text_khow=$option['text_khow'];
}

?>
 <?= $form->field($modelSen, 'option[text_khow]')->textArea(['rows' => '2', 'value' =>$text_khow]) ?>
 
  <?php ActiveForm::end(); ?>
  
</div>

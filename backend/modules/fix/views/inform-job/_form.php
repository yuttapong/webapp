<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\AjaxSubmitButton;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformJob */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inform-job-form">

    <?php $form = ActiveForm::begin([
    		'id' => 'login-form',
    		//'enableAjaxValidation' => false,
    		//'enableClientValidation' => true,
    ]); ?>
    <?= $form->field($model, 'list')->textInput(['maxlength' => true]) ?>
   
    <?php //= $form->field($model, 'job_list_id')->textInput() ?>
    <?php //= $form->field($model, 'responsible_id')->textInput() ?>
    <?php ///= $form->field($model, 'responsible_name')->textInput(['maxlength' => true]) ?>
 <?= $form->field($model, 'problem')->textarea(['rows' => 1]) ?>
    <?= $form->field($model, 'solution')->textarea(['rows' => 1]) ?>
     <?= $form->field($model, 'description')->textarea(['rows' => 1]) ?>
      <?php 
    echo'<h5>วัสดุที่ใช้งาน</h5>';
    echo $this->render("_items-inventory",[
    		'modelInven' => $modelInven,
    		'form' => $form,
    ]);
    
    ?> 
     <div class="form-group">
  <?php 
  $url=Url::to(['inform-job/create','inform_fix_id'=>$_GET['inform_fix_id']]);
  if(!$model->isNewRecord){
  	$url=Url::to(['inform-job/update','inform_fix_id'=>$model->inform_fix_id,'job_id'=>$model->id]);
  }
  if (Yii::$app->request->isAjax) {
  AjaxSubmitButton::begin([
        'label'=>'เพิ่มงาน',
        'ajaxOptions'=>
            [
                'type'=>'POST',
                'url'=> $url,
                
                'cache' => false,
                'success' => new \yii\web\JsExpression('function(html){
    	
		    		if(html=="1"){	
    					$.pjax.reload({container:"#countries"});
    					$(\'#modal\').modal(\'hide\');
    		 
		    		}else{
				 			$("#modal .modal-body").html(html);
		    		}
                }'),
            ],
            'options' => ['type' => 'submit','id'=>'login-formx'],
        ]);
   AjaxSubmitButton::end();
  }else{
  	echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
  }
   ?>
   
   
       
    </div>
   
    <?php ActiveForm::end(); ?>

</div>


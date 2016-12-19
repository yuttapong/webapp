<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use kartik\daterange\DateRangePicker;
use common\widgets\AjaxSubmitButton;
use yii\helpers\Url;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
use common\models\Calendar;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-event-form">

    <?php $form = ActiveForm::begin(); ?>
   
    <?php 
    if(!empty($_GET['id']) && $model->isNewRecord){ 
    	$model->table_name='fix_inform_fix';
    	$model->slug=Calendar::TYPE_FIX_APPOINTMENTS;
    	$model->table_key=$_GET['id'];
    	echo $form->field($model, 'table_name')->hiddenInput()->label(false);
		echo $form->field($model, 'table_key')->hiddenInput()->label(false);
    }
?>
<div class="row">
	<div class="col-sm-4">
<?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
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
	<div class="col-sm-4">
		<?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
        		'type' => DateTimePicker::TYPE_INPUT,
			    'options' => ['placeholder' => 'Enter event time ...'],
					'pluginOptions' => [
					'format' => 'dd-mm-yyyy hh:ii',
						'autoclose' => true,
						'allowClear' => true,
					]
			]);
		?> 
		</div>
		<div class="col-sm-4">
		<?php 
		echo $form->field($model, 'slug')
		->dropDownList(
				$model->typeItems,           // Flat array ('id'=>'label')
				['prompt'=>'-เลือก-']    // options
		)->label('ประเภทการแจ้ง');
		?>
		</div>
</div>
		
        <?php 
        
        ?>  

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    
<?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'options' => ['rows' => 1],
        'preset' => 'basic'
    ]) ?>


    <div class="form-group">
    <?php 
    $url=Url::to(['/fix/work-event/create']);
   if(!$model->isNewRecord){
    	$url=Url::to(['/fix/work-event/update','id'=>$model->id]);
   }
    if (Yii::$app->request->isAjax) {
    	AjaxSubmitButton::begin([
    	'label'=>'บันทึกข้อมูล',
    	'ajaxOptions'=>
    	[
    	'type'=>'POST',
    	'url'=> $url,
    	'cache' => false,
    	'success' => new \yii\web\JsExpression('function(html){
   
		    		if(html=="1"){ 
    					$(\'#modal\').modal(\'hide\');
    		 			$.pjax.reload({container:"#p-inform-fixes"}) ;
		    		}else{
				 			$("#modal .modal-body").html(html);
		    		}
                }'),
                    ],
                    'options' => ['type' => 'submit','id'=>'login-formx'],
                    ]);
                    AjaxSubmitButton::end();
    }else{
    ?>
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
   <?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

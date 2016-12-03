<?php 

use backend\modules\qtn\RequestAsset;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;
use yii\widgets\ActiveForm;
$proc=$_POST['proc'];
$survey_id=$_POST['survey_id'];
$tab_id=$_POST['tab_id'];
$tite_id=$_POST['tite_id'];
if($modelQuestion->isNewRecord){
	$type_id=$_POST['type_id'];
	$modelQuestion->type_id=$type_id;
}

$j=1;
$itemsRes[] =	['content'=>'<input type="hidden" name="cho-line" id="cho-line" value="'.($j-1).'" >' ];
RequestAsset::register($this);
$this->registerJs(
	"$('#xxx').click(function(){
		if($('#question').val()!=''){
			   $.ajax({
	                        url: $('#login-form').attr('action'),
	                        type: 'post',
	                        data: $('#login-form').serialize(),
	                        success: function(data) {
								$(\"#pQuestion\").modal(\"hide\");
								if('".$proc."'=='add'){
									$(\"#list-responsibility_".$tite_id."\").append(data);
								}
									if('".$proc."'=='edit'){
										$(\"#del_qtn_".$modelQuestion->id."\").html(data);   
									}
		
	                        }
	                });
			}   
         return false;
      });  "
);	
////
$form = ActiveForm::begin([
	       'id' => 'login-form',
        'action' => ['survey/save-choice'],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
]); 
  echo Html::hiddenInput('type_id',$type_id); 
  echo Html::hiddenInput('survey_id',$survey_id);
  echo Html::hiddenInput('tab_id',$tab_id);
  echo Html::hiddenInput('tite_id',$tite_id);
  echo Html::hiddenInput('id',$modelQuestion->id);
?>
  <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
				ประเภท
		   </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
            <?= Html::activeDropDownList($modelQuestion,'type_id',['1' => 'Yes/No', '2' => 'Text Box', '9' => 'Date', '10' => 'Numeric']) ?>
            </div>
 </div>
  <div class="row">
            <div class="col-xs-2 col-sm-2 col-md-2">
				คำถาม
		   </div>
            <div class="col-xs-10 col-sm-10 col-md-10">
               <?= $form->field($modelQuestion, 'name')->textInput(['maxlength' => true]) ?>
     
            </div>
 </div><br>
    
     <div class="form-group">
        <?= Html::Button( 'บันทึกx', ['class' =>  'btn btn-primary','id'=>'xxx']) ?>
        <?php 
        
        ?>
        <?php //Html::a(Yii::t('app', 'Cancel'),['index'],['class'=> 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end();?>
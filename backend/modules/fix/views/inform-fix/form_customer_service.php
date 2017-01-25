<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\AjaxSubmitButton;
use yii\helpers\Url;
use kartik\datetime\DateTimePicker;

$form = ActiveForm::begin([
		'id' => 'service-form',
]);
		if(count($dataQuestion)>0){
			$i=1;
			foreach ($dataQuestion as $kQue=> $v_tab) {
				
				
				echo $i.'.  '.$v_tab['question'].'<br>';
				if($v_tab['type']=='4'){ 
					
					foreach ($v_tab['choices'] as $Kchoices=> $Vchoices) {
						$check='';
						if(!empty($v_tab['answer'][$Kchoices])){
							$check='checked="checked"';
							echo Html::hiddenInput('ResponseChoice['.$kQue.'][id]',$v_tab['answer'][$Kchoices]);
						}
						echo Html::hiddenInput('ResponseChoice['.$kQue.'][table_talbe]','fix_inform_fix');
						echo Html::hiddenInput('ResponseChoice['.$kQue.'][table_key]',$model->id);
						echo Html::hiddenInput('ResponseChoice['.$kQue.'][question_id]',$kQue);
						echo Html::hiddenInput('ResponseChoice['.$kQue.'][type]','single');
						echo '<input type="radio" name="ResponseChoice['.$kQue.'][choice_id]" value="'.$Kchoices.'" lass="option-input radio" '.$check.'> '.$Vchoices;
						if($v_tab['type_choices'][$Kchoices]=='another'){
							echo Html::hiddenInput('ResponseOther['.$kQue.'][table_talbe]','fix_inform_fix');
							echo Html::hiddenInput('ResponseOther['.$kQue.'][table_key]',$model->id);
							echo Html::hiddenInput('ResponseOther['.$kQue.'][question_id]',$kQue);
							echo Html::hiddenInput('ResponseOther['.$kQue.'][choice_id]',$Kchoices);
							$response='';
							if(!empty($v_tab['answerOther'][$Kchoices]['response']) && !empty($v_tab['answer'][$Kchoices]) ){
								$response=$v_tab['answerOther'][$Kchoices]['response'];
								
							}
							if(!empty($v_tab['answerOther'][$Kchoices]['other_id'])){
								echo Html::hiddenInput('ResponseOther['.$kQue.'][other_id]',$v_tab['answerOther'][$Kchoices]['other_id']);
							}
							echo '<input type="text" name="ResponseOther['.$kQue.'][response]" value="'.$response.'"><br>';
						}else{
							echo '<br>';
						}
					}
					
				}
				
				if($v_tab['type']=='2'){ 
					echo Html::hiddenInput('ResponseText['.$kQue.'][table_talbe]','fix_inform_fix');
					echo Html::hiddenInput('ResponseText['.$kQue.'][table_key]',$model->id);
					echo Html::hiddenInput('ResponseText['.$kQue.'][question_id]',$kQue);
					$response='';
					if(!empty($v_tab['answer'])){
						$response=$v_tab['answer'];
					}
				
					echo Html::textarea('ResponseText['.$kQue.'][response]',$response).'<br>';
					
				}
				if($v_tab['type']=='9'){
					echo Html::hiddenInput('ResponseText['.$kQue.'][table_talbe]','fix_inform_fix');
					echo Html::hiddenInput('ResponseText['.$kQue.'][table_key]',$model->id);
					echo Html::hiddenInput('ResponseText['.$kQue.'][question_id]',$kQue);
					$response='';
					if(!empty($v_tab['answer'])){
						$response=$v_tab['answer'];
					}
					echo DateTimePicker::TYPE_INPUT;
					echo DateTimePicker::widget([
							'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,
							'name' =>'ResponseText['.$kQue.'][response]',
							'value' => $response,
							'options' => ['placeholder' => 'Select operating time ...'],
							'pluginOptions' => [
									'autoclose'=>true,
       								 'format' => 'dd-mm-yyyy hh:ii'
								
							]
					]);
				}
				$i++;
			}
		} 
		echo '<br><br>';
		if (Yii::$app->request->isAjax) {
			$url=Url::to(['inform-fix/customer-service','id'=>$model->id]);
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
		                'options' => ['type' => 'submit','id'=>'service-formx'],
		                ]);
		                AjaxSubmitButton::end();
		}
		?>
		    <?php ActiveForm::end();?>
		
<?php 
use yii\helpers\Html;
use backend\modules\qtn\SurveyAsset;
SurveyAsset::register($this);
if (Yii::$app->request->isAjax) {
echo '<li   class="ui-sortable-handle" id="del_qtn_'.$modelQuestion->id.'">';

}
$link_del=$link_edit= '';
if($proc['edit']=='edit'){
echo '<input type="hidden" name="seq['.$tite_id.'][]"  value="'.$modelQuestion->id.'" >';
$link_del=Html::button('<i class="glyphicon glyphicon-trash"></i>', ['class'=>'x',  'onclick' =>
    				' var url = "'.Yii::$app->urlManager->createUrl(["qtn/question/delete","id"=>$modelQuestion->id]).'"
		if (confirm("ยืนยันการลบข้อมูล") == true) {
			  $.ajax({
		            url: url,
		            type: \'post\',
		            data: {type_id:"'.$modelQuestion->type_id.'",survey_id:"'.$survey_id.'",tab_id:"'.$tab_id.'" ,tite_id:"'.$tite_id.'"  },
		            success:function(data){
					obj = JSON.parse(data);
					if(obj.status=="1"){
						$("#del_qtn_'.$modelQuestion->id.'").remove();
					}else{
						alert("ลบไม่ได้ข้อมูลนี้มีการนำไปใฃ้ ");
					}
		            },
		        }); 
		}
		
 ']);
$link_edit=Html::button('<i class="glyphicon glyphicon-pencil"></i>', [ 'class' => 'x', 'onclick' =>
		' var url = "'.Yii::$app->urlManager->createUrl(["qtn/survey/type-ajax"]).'"
			  $.ajax({
		            url: url,
		            type: \'post\',
		            data: {proc:"edit",type_id:"'.$modelQuestion->type_id.'",survey_id:"'.$survey_id.'",tab_id:"'.$tab_id.'" ,tite_id:"'.$tite_id.'" ,question_id:"'.$modelQuestion->id.'" },
		            success:function(data){
						$("#pQuestion").modal("show");
						$("#modalContent").html(data);
		            },
		        });  '
]);
}
$question_text='';

    		$question_text .=$modelQuestion->seq. $link_del.'&nbsp;'.$link_edit;
    		$question_text .='  <strong> '.$modelQuestion->name.'</strong>';

if($modelQuestion->type_id=='1'){ ?>	
	<div class="row">
		<div class="col-sm-4 col-md-4">
		<?php echo $question_text; ?>
    	</div>
    		<div class="col-sm-7 col-md-7">
		    	<div class="funkyradio"> 
		    			<div class="row">
		    				<div class="col-sm-6 col-md-6">
								<div class="funkyradio-success">
										<input  type="radio" id="radio<?=$modelQuestion->id;?>" name="approve[<?=$modelQuestion->id;?>]"  value="1"  >
											<label for="radio<?=$modelQuestion->id;?>">Yes</label>
									</div>
									</div>
									<div class="col-sm-6 col-md-6">
										<div class="funkyradio-primary">
												<input type="radio" id="radio2<?=$modelQuestion->id;?>" name="approve[<?=$modelQuestion->id;?>]"  value="2"    >
												<label for="radio2<?=$modelQuestion->id;?>">No</label>
										</div>
								</div>
						</div>
					</div>
    		</div>
    	</div>
	<?php }else{
		echo $question_text;
		if($modelQuestion->type_id=='2'){//text
			echo ' <input type="text" name="usrname" required>';
		}elseif($modelQuestion->type_id=='9'){ //date
			echo ' <input type="date" name="usrname" required>';
		}elseif($modelQuestion->type_id=='10'){ //number
			echo '<input type="number" name="quantity" min="1" max="5">';
		}
	}
	if (Yii::$app->request->isAjax) {
	echo '</li>';
	}

	?>


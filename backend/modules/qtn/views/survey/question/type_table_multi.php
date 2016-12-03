<?php 
use backend\modules\qtn\models\SurveyTitle;
use yii\helpers\Html;

$gp_choice=SurveyTitle::findOne( $tite_id);
$link_del=$link_edit= '';
if($proc['edit']=='edit'){
$link_del=Html::button('<i class="glyphicon glyphicon-trash"></i>', ['class'=>'x',  'onclick' =>
		' var url = "'.Yii::$app->urlManager->createUrl(["qtn/question/delete","id"=>11]).'"
		if (confirm("ยืนยันการลบข้อมูล") == true) {
			  $.ajax({
		            url: url,
		            type: \'post\',
		            data: {type_id:11,survey_id:"'.$survey_id.'",tab_id:"'.$tab_id.'" ,tite_id:"'.$tite_id.'"  },
		            success:function(data){
						obj = JSON.parse(data);
						if(obj.status=="1"){
							$("#del_tite_'.$tite_id.'").remove();
						}else{
							alert("ลบไม่ได้ข้อมูลนี้มีการนำไปใฃ้ ");
						}
		            },
		        });
		}

 ']);

$link_edit=Html::button('<i class="glyphicon glyphicon-pencil"></i>', [ 'class' => 'x', 
		'onclick' => ' var url = "'.Yii::$app->urlManager->createUrl(["qtn/survey/type-ajax"]).'"
								  $.ajax({
							            url: url,
							            type: \'post\',
							            data: {proc:"edit",type_id:11,survey_id:"'.$survey_id.'",tab_id:"'.$tab_id.'" ,tite_id:"'.$tite_id.'"  },
							            success:function(data){
											$("#pQuestion").modal("show");
											$("#modalContent").html(data);
											$("#type_id_'.$tite_id.'").val("");
							            },
							        });
					 '
]);

echo '<input type="hidden" name="seq['.$tite_id.'][]"  value="type_id11" >';
}
if (Yii::$app->request->isAjax) {
echo '<li id="del_tite_'.$tite_id.'"  class="ui-sortable-handle"  >';
}

?>
<table style="width:100%" border="1">
<?php 
if ($gp_choice->questionGroupChoices) {
	echo '<tr>';
	echo '<th align="center" > รายการ'.$link_del.'&nbsp;'.$link_edit.'</th>';
	foreach ($gp_choice->questionGroupChoices as $v) {
		echo '<th>'.$v->content.'</th>';
	}
	echo '</tr>';

if(count($item)>0){
	foreach ($item as $key=> $qu) {
		echo '<tr>';
		echo '<td> '.$qu.'</td>';
		for ($i=1;$i<=count($gp_choice->questionGroupChoices);$i++){
				echo '<td><input type="radio" name="gender'.$key.'" value="1" lass="option-input radio"></td>';
		}
		echo '</tr>';
	}
	
}
}
?>
</table>
<?php 	
if (Yii::$app->request->isAjax) {
echo '</li>'; 
}

?>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\UrlRule;
use backend\modules\qtn\models\Question;
use kartik\tabs\TabsX;
use backend\modules\qtn\models\QuestionType;
use yii\bootstrap\Modal;
use backend\modules\qtn\models\SurveyTitle;
use yii\jui\Sortable;
use yii\widgets\ActiveForm;

$data_type=QuestionType::getQuestionType();
$this->title = 'Qtn Questions';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(
		"$('#sen_seq').click(function(){

			   $.ajax({
	                        url: $('#seq-form').attr('action'),
	                        type: 'post',
	                        data: $('#seq-form').serialize(),
	                        success: function(data) {
					
	                        }
	                });
			
         return false;
      });  "
);
$form = ActiveForm::begin([
		'id' => 'seq-form',
		'action' => ['question/question-seq'],
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
]);
echo '<input type="hidden" name="survey_id"  value="'.$survey_id.'" >';
?>
<div class="qtn-question-index">
    <h1><?= Html::encode($this->title) ?></h1>
      <div class="form-group">
        <?= Html::Button( 'จัดลำดับ', ['class' =>  'btn btn-primary','id'=>'sen_seq']) ?>
    </div>
 
</div>
<?php 
//echo '<pre>';
//print_r($question_c);
//echo '</pre>';
$items_d=[];
$items_x=[];
if(count($question_c)>0){
	foreach ($question_c as $k_tab=> $v_tab) {
		$items_d['label']=$v_tab['tab_name'] ;
		$text=  '<div class="container">';
	
		foreach ($v_tab['item'] as $k_title=> $v_title) {
				$itemsRes=[];
			$text.='<div class="row" id="title_'.$k_title.'">';
			$text .=  '<h4> '.$v_title['title_name'].'เพิ่มข้อมูล '. Html::dropDownList('type_id', 0,$data_type,
					['prompt'=>'-เลือกประเภท-',
							'id'=>'type_id_'.$k_title,
							'onchange'=>'
								var url = "'.Yii::$app->urlManager->createUrl(["qtn/survey/type-ajax"]).'"
								  $.ajax({
							            url: url,
							            type: \'post\',
							            data: {proc:"add",type_id:$(this).val(),survey_id:"'.$survey_id.'",tab_id:"'.$k_tab.'" ,tite_id:"'.$k_title.'"  },
							            success:function(data){
											$("#pQuestion").modal("show");
											$("#modalContent").html(data);
											$("#type_id_'.$k_title.'").val("");
							            },
							        }); '
					]
			);
			$text.='</h4> ';
				if(!empty($v_title['items'])){
					foreach ($v_title['items'] as $k_question=> $v_question) {
						$item_text='';
						if($v_question['type_id']=='4' || $v_question['type_id']=='5' ){
							$item_text .= 	$this->render('type_choice', [
									'survey_id' =>  $survey_id,
									'tab_id' =>  $k_tab,
									'tite_id' => $k_title,
									'modelQuestion' =>$v_question['modelQuestion'],
									'proc' =>['edit'=>'edit'] ,
							]);
						}else{
							$item_text .= 	$this->render('type_choice_single', [
									'survey_id' =>  $survey_id,
									'tab_id' =>  $k_tab,
									'tite_id' => $k_title,
									'modelQuestion' =>$v_question['modelQuestion'],
									'proc' =>['edit'=>'edit'] ,
							]);
						}
						$itemsRes[]= [
						'content' =>$item_text,
						'options' => ['data' => ['id'=>$v_question['modelQuestion']->id]  ,'id' =>'del_qtn_'.$v_question['modelQuestion']->id],
						];
				
					}
			
				}
				if(!empty($v_title['item'])){
					$item_text='';
					foreach ($v_title['item'] as $k_type=> $v_type) {
						$item_text .= $this->render('type_table_multi', [
								'survey_id' =>  $survey_id,
								'tab_id' =>  $k_tab,
								'tite_id' => $k_title,
								'item' =>$v_type['question'],
								'proc' =>['edit'=>'edit'] ,
						]);
					}
					$itemsRes[]= [
						'content' =>$item_text,
						'options' => ['data' => ['id'=>'Type'.$k_type  ] ,'id' =>'del_tite_'.$k_type ],
						];
				}
				 $text.= Sortable::widget([
						'items' =>$itemsRes,
						'options' => ['tag' => 'ul', 'id' => 'list-responsibility_'.$k_title, 'class' => 'list-unstyled'],
						'itemOptions' => ['tag' => 'li','data'=>['id'=>'$item->id'],'id'=>'$item' ,'class'=>'ui-sortable-handle'],
						'clientOptions' => ['cursor' => 'move'],
				]);
			$text.='</div>';
  		}

  		$text.='</div>';
  		$items_d['content']=$text;
		$items_x[]=$items_d;
	} 
} 
echo TabsX::widget([
		'items'=>$items_x,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);

	?>
	    <?php ActiveForm::end();?>
	       <?php
       Modal::begin([
            'header' => 'คำภาม',
            'id' => 'pQuestion',
            'size' => 'modal-lg',
            'clientOptions' => [
            		'backdrop' => 'static',
            		'keyboard' => false
            ],
        ]);
        echo "<div id='modalContent'></div>";
        Modal::end();
    ?>

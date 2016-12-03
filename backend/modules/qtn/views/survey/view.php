<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\Survey */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="survey-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>


</div>

<?php 
//echo '<pre>';
//print_r($question_c);
//echo '</pre>';
$items_d=[];
$items_x=[];
if(count($questions)>0){
	foreach ($questions as $k_tab=> $v_tab) {
		$items_d['label']=$v_tab['tab_name'] ;
		$text=  '<div class="container">';
		foreach ($v_tab['item'] as $k_title=> $v_title) {
			$text.='<div class="row" id="title_'.$k_title.'">';
			if($v_title['title_hide']!=1){
			$text .=  '<h4> '.$v_title['title_name'].'</h4>';
			}
				if(!empty($v_title['items'])){
					foreach ($v_title['items'] as $k_question=> $v_question) {
						if($v_question['type_id']=='4' || $v_question['type_id']=='5' ){
							$text .= 	$this->render('question/type_choice', [
									'survey_id' =>  $survey_id,
									'tab_id' =>  $k_tab,
									'tite_id' => $k_title,
									'modelQuestion' =>$v_question['modelQuestion'],
									'proc' =>['edit'=>'view'] ,
							]);
						}else{
							$text .= 	$this->render('question/type_choice_single', [
									'survey_id' =>  $survey_id,
									'tab_id' =>  $k_tab,
									'tite_id' => $k_title,
									'modelQuestion' =>$v_question['modelQuestion'],
									'proc' =>['edit'=>'view'] ,
							]);
						}
					}
				}
				if(!empty($v_title['item'])){
					foreach ($v_title['item'] as $k_type=> $v_type) {
				
						$text .= $this->render('question/type_table_multi', [
								'survey_id' =>  $survey_id,
								'tab_id' =>  $k_tab,
								'tite_id' => $k_title,
								'item' =>$v_type['question'],
								'proc' =>['edit'=>'view'] ,
						]);
					}
				}
			$text.='</div>';
  		}
  		$text.='</div>';
  		$items_d['content']=$text;
  	//	$items_d['active']='true';
		$items_x[]=$items_d;
	} 
} 

echo TabsX::widget([
		'items'=>$items_x,
		'position'=>TabsX::POS_ABOVE,
		'encodeLabels'=>false
]);

	?>
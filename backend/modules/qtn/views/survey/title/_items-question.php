<?php
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;

$itemsRes= [];
	$hidd_ck='';$j=1;

if ($modelTite->questions) {
	foreach ($modelTite->questions as $v) {
		if( $v->type_id=='11'){
		$name = $v->name;
		$html = "<p><div class='row'><div class='col-xs-7'>";
		$hidd_ck .= Html::hiddenInput('Question[old_id]['.$j.']',$v->id);
	//	$html .= Html::hiddenInput('Question[question_message_id]['.$j.']',$v->question_message_id);
		$html .= Html::input('hidden1','Question[name]['.$j.']',$name,['class'=>'form-control','readonly'=>false]);
		$html .= "</div>";
		$html .="<div class='col-xs-4'>";
		$html .= Html::textarea('Question[content]['.$j.']',$v->content,['class'=>'form-control','rows'=>1]);
		$html .= "</div>";
		$html .="<div class='col-xs-1'>";
		$html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger', 'value' => 'que_check_'.$j ]);
		$html .= "</div></div></p>";
		$hidd_ck .='<input type="hidden" id="que_check_'.$j.'" name="que-check['.$j.']" value="edit">';
		$itemsRes[] = ['content'=>$html	];
		$j++;
		}
	}

}		$itemsRes[] =	['content'=>'<input type="hidden" name="que-line" id="que-line" value="'.($j-1).'" >'.$hidd_ck ];
?>
<div class="item panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h3 class="panel-title">คำถาม</h3>
            </div>
         
            <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                <?=Html::button('+',['class'=>'add-question btn btn-success'])?>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-xs-7 text-center"><strong>รายการคำถาม</strong></div>
       <div class="col-xs-5 text-center"><strong>รายละเอียด</strong></div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([ 
            'items' =>$itemsRes,
            'options' => ['tag' => 'ul', 'id' => 'list-question', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>

    </div>
    </div>
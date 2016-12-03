<?php
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;

$itemsRes= [];
$j=1;
$hidd_ck='';
if ($modelTite->questionGroupChoices) {
	foreach ($modelTite->questionGroupChoices as $v) {
		$name = $v->content;
		$html = "<p><div class='row' id='dcon_check_".$j."' ><div class='col-xs-9'>";

		$hidd_ck .= Html::hiddenInput('QuestionGroupChoice[old_id]['.$j.']',$v->id);
		$html .= Html::hiddenInput('QuestionGroupChoice[question_message_id]['.$j.']',$v->question_message_id);
		$html .= Html::input('hidden','QuestionGroupChoice[name]['.$j.']',$name,['class'=>'form-control','readonly'=>true]);
		$html .= Html::tag('span',$name);
		$html .= "</div>";
		$html .="<div class='col-xs-2'>";
		$html .= Html::input('number','QuestionGroupChoice[score]['.$j.']',$v->score,['class'=>'form-control']);
		$html .= "</div>";
		$html .="<div class='col-xs-1'>";
		$html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger', 'value' => 'con_check_'.$j , 'onclick' => 'removeItem(this.value);']);
		$html .= "</div></div></p>";
		$hidd_ck .='<input type="hidden" id="con_check_'.$j.'" name="con-check['.$j.']" value="edit">';
		$itemsRes[] = ['content'=>$html	];
		$j++;
	}
$itemsRes[] =	['content'=>'<input type="hidden" name="con-line" id="con-line" value="'.($j-1).'" >'.$hidd_ck ];	
}else{
$itemsRes[] =	['content'=>'<input type="hidden" name="con-line" id="con-line" value="'.($j-1).'" >'.$hidd_ck ];	
}	
?>
<div class="item panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <h3 class="panel-title">Choice</h3>
            </div>
            <div class="col-xs-10 col-sm-7 col-md-8">
                <?php 
                echo Typeahead::widget([
                		'name' => 'country',
                		'options' => ['placeholder' => 'พิมพ์ค้นหา ...','id'=>'con-text'],
                		'pluginOptions' => ['highlight'=>true],
                		'dataset' => [
                				[
                						'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                						'display' => 'name',
                						'remote' => [
                								'url' => Url::to(['message-list']) . '?q=%QUERY',
                								'wildcard' => '%QUERY'
                						]
                				]
                		],
                		'pluginEvents' => [
                				"typeahead:select" => 'function(index,item){
                      var btnDel = " <button type=\"button\" class=\"remove-res btn btn-xs btn-danger\" onclick=\"if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่\')){$(this).parent().parent().remove();}\">x</button>";
                      var res = $("#list-responsibility");
                	 var row=parseInt($("#con-line").val())+1;
                      var li = "<li class=\"row\"><p><div class=\"col-xs-9\">";
                	   li += "<input type=\"hidden\" name=\"con-check["+row+"]\" value=\"add\">";
                      li += "<input type=\"hidden\" name=\"QuestionGroupChoice[question_message_id]["+row+"]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"QuestionGroupChoice[name]["+row+"]\" class=\"form-control\" value=\""+item.name+"\">";
                      li += item.name;
                				   li += "</div><div class=\"col-xs-2\">";
                				li += "<input type=\"hidden1\" name=\"QuestionGroupChoice[score]["+row+"]\" class=\"form-control\" value=\"0\">";
                				       li += "</div>";
                      li += "</div><div class=\"col-xs-1\">"+btnDel+"</div>";
                      li += "</div></p><li>"
                      res.append(li);
                		$(\'#con-line\').val(row);		
                      $(this).typeahead(\'val\',\'\');
                      }', ]
                ]); 
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?=Html::button('+',['class'=>'add-res btn btn-success','onclick' => 'addItem("con","QuestionGroupChoice");'])?>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-xs-7 text-center"><strong>รายการ</strong></div>
       <div class="col-xs-5 text-center"><strong>คะแนน</strong></div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([ 
            'items' =>$itemsRes,
            'options' => ['tag' => 'ul', 'id' => 'list-responsibility', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>

    </div>
    </div>
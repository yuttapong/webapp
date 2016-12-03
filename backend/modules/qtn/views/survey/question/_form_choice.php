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
$itemsRes= [];
$j=1;
$hidd_ck='';
if ($modelQuestion->questionChoices) {
	foreach ($modelQuestion->questionChoices as $v) {
		$name = $v->content;
		$html = "<p><div class='row' id='dcho_check_".$j."' ><div class='col-xs-7'>";
		$hidd_ck .= Html::hiddenInput('QuestionChoice[old_id]['.$j.']',$v->id);
		$html .= Html::hiddenInput('QuestionChoice[question_message_id]['.$j.']',$v->question_message_id);
		$html .= Html::input('hidden','QuestionChoice[name]['.$j.']',$name,['class'=>'form-control','readonly'=>true]);
		$html .= Html::tag('span',$name);
		$html .= "</div>";
		$html .="<div class='col-xs-2'>";
		$html .= Html::input('number','QuestionChoice[score]['.$j.']',$v->score,['class'=>'form-control']);
		$html .= "</div>";
		$html .="<div class='col-xs-2'>";
		$html .=Html::activeDropDownList($v, 'type', $v->typeStatus,['name'=>'QuestionChoice[type]['.$j.']','class'=>'form-control' ] );

		$html .= "</div>";
		$html .="<div class='col-xs-1'>";
		$html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger', 'value' => 'cho_check_'.$j , 'onclick' => 'removeItem(this.value);']);
		$html .= "</div></div></p>";
		$hidd_ck .='<input type="hidden" id="cho_check_'.$j.'" name="cho-check['.$j.']" value="edit">';
	
		$itemsRes[] = ['content'=>$html	];
		$j++;
		
	}
	$itemsRes[] =	['content'=>'<input type="hidden" name="cho-line" id="cho-line" value="'.($j-1).'" >'.$hidd_ck ];
}else{
$itemsRes[] =	['content'=>'<input type="hidden" name="cho-line" id="cho-line" value="'.($j-1).'" >'.$hidd_ck ];	
}




RequestAsset::register($this);
$this->registerJs(
	"$('#xxx').click(function(){
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
         return false;
      }); "
);
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
            <?= Html::activeDropDownList($modelQuestion,'type_id',['4' => 'Radio Buttons', '5' => 'Check Boxes']) ?>
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
    <div class="item panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <h3 class="panel-title">Choice</h3>
            </div>
            <div class="col-xs-10 col-sm-7 col-md-8">
                <?php 
                echo Typeahead::widget([
                		'name' => 'searching',
                		'options' => ['placeholder' => 'พิมพ์ค้นหา ...','id'=>'cho-text'],
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
                	 var row=parseInt($("#cho-line").val())+1;
                      var li = "<li class=\"row\"><p><div class=\"col-xs-7\">";
                	   li += "<input type=\"hidden\" name=\"cho-check["+row+"]\" value=\"add\">";
                      li += "<input type=\"hidden\" name=\"QuestionChoice[question_message_id]["+row+"]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"QuestionChoice[name]["+row+"]\" class=\"form-control\" value=\""+item.name+"\">";
                      li += item.name;	
                				 li += "</div>";
                				li +=	"<div class=\"col-xs-2\">";
                				li += "<input type=\"number\" name=\"QuestionChoice[score]["+row+"]\" class=\"form-control\" value=\"0\">";
                				       li += "</div>";
                				li +=	"<div class=\"col-xs-2\">";
                				 li += "<select name=\"QuestionChoice[type]["+row+"]\" class=\"form-control\" >";
                				li += "<option value=\"choice\">choice</option>";
                				li += "<option value=\"another\">อื่นๆ ระบบ..</option>";
                				 li += "</select>";
                				  li += "</div>";
                      li += "</div><div class=\"col-xs-1\">"+btnDel+"</div>";
                      li += "</div></p><li>"
                      res.append(li);
                		$(\'#cho-line\').val(row);		
                      $(this).typeahead(\'val\',\'\');
                      }', ]
                ]); 
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?=Html::button('+',['class'=>'add-res btn btn-success','onclick' => 'addItem("cho","QuestionChoice");'])?>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-xs-7 text-center"><strong>รายการ</strong></div>
       <div class="col-xs-2 text-center"><strong>คะแนน</strong></div>
       <div class="col-xs-2 text-center"><strong>อื่น</strong></div>
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
     <div class="form-group">
        <?= Html::Button( 'บันทึกtx', ['class' =>  'btn btn-primary','id'=>'xxx']) ?>
        <?php 
        
        ?>
        <?= Html::a(Yii::t('app', 'Cancel'),['index'],['class'=> 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end();?>
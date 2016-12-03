<?php
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;
use kartik\typeahead\Typeahead;


$itemsInv = [];
$j=1;
	$hidd_ck='';
if (count($modelInven)>0) {
	//echo '<pre>';
	//print_r($modelInven);
	//echo '</pre>';

    foreach ($modelInven as $v) {
 
       // $title = $v->list;//\backend\modules\org\models\OrgJobOption::findOne(1)->title;
        $html = "<p><div class='row'  id='dinv_check_".$j."'><div class='col-xs-6'>";
        $ck_text='add';
        if($v->id!=''){
        	$ck_text='edit';
        }
       // $hidd_ck .= Html::hiddenInput('chk['.$j.'][old_id]',$ck_text);
       // $html .= Html::hiddenInput('dataProp[option_id]['.$j.']',$v->option_id);
       //$html .= Html::input('hidden1','dataInven['.$j.'][title]',$title,['class'=>'form-control']);
        $html  .= $form->field($v, "[{$j}]name")->textInput(['maxlength' => true])->label(false);
       $html  .= $form->field($v, "[{$j}]id")->hiddenInput(['maxlength' => true])->label(false);
        //$html .= Html::tag('span',$title);
        $html .= "</div>";
        $html .= '<div class="col-xs-2">';
        $html  .= $form->field($v, "[{$j}]qty")->textInput(['maxlength' => true])->label(false);
         $html .='</div>';
        $html .= '<div class="col-xs-2">';
        $html  .= $form->field($v, "[{$j}]unit")->textInput(['maxlength' => true])->label(false);
        $html .='</div>';
        
         
        $html .= "<div class='col-xs-1'>";
		$html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger', 'value' => 'inv_check_'.$j , 'onclick' => 'removeItem(this.value);']);
        $html .= "</div></div></p>";
        $itemsInv[] = ['content'=>$html];
        $hidd_ck .='<input type="hidden" id="inv_check_'.$j.'" name="inv[check]['.$j.']" value="'.$ck_text.'">';
        $hidd_ck .='<input type="hidden" id="inv_check_'.$j.'" name="inv[key]['.$j.']" value="'.$v->id.'">';
        $j++;
    }
    $itemsInv[] =	['content'=>'<input type="hidden" name="inv-line" id="inv-line" value="'.($j-1).'" >'.$hidd_ck ];
}else{
	$itemsInv[] =	['content'=>'<input type="hidden" name="inv-line" id="inv-line" value="'.($j-1).'" >'.$hidd_ck ];
}
?>
<div class="item panel panel-default">
    <div class="panel-heading">
         <div class="row">
            <div class="col-xs-11 col-sm-11 col-md-11">
        		<?php 
                echo Typeahead::widget([
                		'name' => 'searching',
                		'options' => ['placeholder' => 'พิมพ์วัสดุค้นหา ...','id'=>'inv-text'],
                		'pluginOptions' => ['highlight'=>true],
                		'dataset' => [
                				[
                						'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                						'display' => 'title',
                						'remote' => [
                								'url' => Url::to(['job-option/ajax-list']) . '?type=property&q=%QUERY',
                								'wildcard' => '%QUERY'
                						]
                				]
                		],
                		'pluginEvents' => [
                				"typeahead:select" => 'function(index,item){
                      var btnDel = " <button type=\"button\" class=\"remove-res btn btn-xs btn-danger\" onclick=\"$(this).parent().parent().remove();\">x</button>";
                      var res = $("#list-inv");
                	 var row=parseInt($("#inv-line").val())+1;
                      var li = "<li class=\"row\"><p><div class=\"col-xs-11\">";
                	   li += "<input type=\"hidden\" name=\"pos-check["+row+"]\" value=\"property\">";
                      li += "<input type=\"hidden\" name=\"dataProp[option_id]["+row+"]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"dataProp[title]["+row+"]\" class=\"form-control\" value=\""+item.title+"\">";
                        li += item.title;	
                	  li += "</div>";	
                      li += "</div><div class=\"col-xs-1\">"+btnDel+"</div>";
                      li += "</div></p><li>"
                      res.append(li);
                		$(\'#pos-line\').val(row);		
                      $(this).typeahead(\'val\',\'\');
                      }', ]
                ]); 
                ?>
                </div>
                  <div class="col-xs-1 col-sm-1 col-md-1">
              		  <?=Html::button('+',['class'=>'add-res btn btn-success','onclick' => 'addItem("inv","InformMaterial");'])?>
            	</div>
         </div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([
            'items' => $itemsInv,
            'options' => ['tag' => 'ul', 'id' => 'list-inv', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>
    </div>
</div>





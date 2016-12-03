<?php
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;
use kartik\typeahead\Typeahead;


$itemsProp = [];
$j=1;
	$hidd_ck='';
	if (count($modelsRes)>0) {
    foreach ($modelsRes as $v) {
        $title = $v->title;//\backend\modules\org\models\OrgJobOption::findOne(1)->title;
        $html = "<p><div class='row'  id='dres_check_".$j."'><div class='col-xs-11'>";
        $hidd_ck .= Html::hiddenInput('dataRes[old_id]['.$j.']',$v->option_id);
        $html .= Html::hiddenInput('dataRes[option_id]['.$j.']',$v->option_id);
        $html .= Html::input('hidden','dataRes[title]['.$j.']',$title,['class'=>'form-control']);
        $html .= Html::tag('span',$title);
        $html .= "</div><div class='col-xs-1'>";
		$html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger', 'value' => 'res_check_'.$j , 'onclick' => 'removeItem(this.value);']);
        $html .= "</div></div></p>";
        $itemsProp[] = ['content'=>$html];
        $hidd_ck .='<input type="hidden" id="res_check_'.$j.'" name="res-check['.$j.']" value="edit">';
        $j++;
    }
    $itemsProp[] =	['content'=>'<input type="hidden" name="res-line" id="res-line" value="'.($j-1).'" >'.$hidd_ck ];
}else{
	$itemsProp[] =	['content'=>'<input type="hidden" name="res-line" id="res-line" value="'.($j-1).'" >'.$hidd_ck ];
}
?>
<div class="item panel panel-default">
    <div class="panel-heading">
         <div class="row">
            <div class="col-xs-10 col-sm-10 col-md-10">
        		<?php 
                echo Typeahead::widget([
                		'name' => 'searching',
                		'options' => ['placeholder' => 'พิมพ์ค้นหา ...','id'=>'res-text'],
                		'pluginOptions' => ['highlight'=>true],
                		'dataset' => [
                				[
                						'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                						'display' => 'title',
                						'remote' => [
                								'url' => Url::to(['job-option/ajax-list']) . '?type=responsibility&q=%QUERY',
                								'wildcard' => '%QUERY'
                						]
                				]
                		],
                		'pluginEvents' => [
                				"typeahead:select" => 'function(index,item){
                      var btnDel = " <button type=\"button\" class=\"remove-res btn btn-xs btn-danger\" onclick=\"$(this).parent().parent().remove();\">x</button>";
                      var res = $("#list-res");
                	 var row=parseInt($("#res-line").val())+1;
                      var li = "<li class=\"row\"><p><div class=\"col-xs-11\">";
                	   li += "<input type=\"hidden\" name=\"res-check["+row+"]\" value=\"property\">";
                      li += "<input type=\"hidden\" name=\"dataRes[option_id]["+row+"]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"dataRes[title]["+row+"]\" class=\"form-control\" value=\""+item.title+"\">";
                        li += item.title;	
                	  li += "</div>";	
                      li += "</div><div class=\"col-xs-1\">"+btnDel+"</div>";
                      li += "</div></p><li>"
                      res.append(li);
                		$(\'#res-line\').val(row);		
                      $(this).typeahead(\'val\',\'\');
                      }', ]
                ]); 
                ?>
                </div>
                  <div class="col-xs-1 col-sm-1 col-md-1">
              		  <?=Html::button('+',['class'=>'add-res btn btn-success','onclick' => 'addItem("res","dataRes");'])?>
            	</div>
         </div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([
            'items' => $itemsProp,
            'options' => ['tag' => 'ul', 'id' => 'list-res', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>
    </div>
</div>





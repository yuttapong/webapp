<?php
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;


$itemsRes= [];
if ($model->optionResponsibilities) {
    foreach ($model->optionResponsibilities as $v) {
        $title = $v->title;
        $html = "<p><div class='row'><div class='col-xs-11'>";
        $html .= Html::hiddenInput('dataRes[id][]',$v->id);
        $html .= Html::input('hidden','dataRes[title][]',$title,['class'=>'form-control','readonly'=>true]);
        $html .= Html::tag('span',$title);
        $html .= "</div><div class='col-xs-1'>";
        $html .= Html::button('x',['class'=>'remove-res btn btn-xs btn-danger']);
        $html .= "</div></div></p>";
        $itemsRes[] = ['content'=>$html];
    }
}

?>
<div class="item panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <h3 class="panel-title">หน้าที่รับผิดชอบ</h3>
            </div>
            <div class="col-xs-10 col-sm-7 col-md-8">
                <?php
                echo Typeahead::widget([
                    'name' => 'search_property',
                    'options' => ['placeholder' => 'พิมพ์ค้นหา ...','id'=>'res-text'],
                    'scrollable' => true,
                    'pluginOptions' => ['highlight'=>true],
                    'dataset' => [
                        [
                            'remote' => Url::to(['responsibility-list']),
                            'display' => 'title',
                            'limit' => 10
                        ]
                    ],
                    'pluginEvents' => [
                        "typeahead:select" => 'function(index,item){ 
                      var btnDel = " <button type=\"button\" class=\"remove-res btn btn-xs btn-danger\" onclick=\"if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่\')){$(this).parent().parent().remove();}\">x</button>";
                      var res = $("#list-responsibility");
                      var li = "<li class=\"row\"><p><div class=\"col-xs-11\">";
                      li += "<input type=\"hidden\" name=\"dataRes[id][]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"dataRes[title][]\" class=\"form-control\" value=\""+item.title+"\">";
                      li += item.title;
                      li += "</div><div class=\"col-xs-1\">"+btnDel+"</div>";
                      li += "</div></p><li>"
                      res.append(li);
                      $(this).typeahead(\'val\',\'\');
                      }',
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-1 col-sm-1 col-md-1">
                <?=Html::button('+',['class'=>'add-res btn btn-success'])?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([
            'items' => $itemsRes,
            'options' => ['tag' => 'ul', 'id' => 'list-responsibility', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>

    </div>
</div>




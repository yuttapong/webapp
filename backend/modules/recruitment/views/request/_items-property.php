<?php
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Html;
use yii\jui\Sortable;

$itemsProp = [];
if ($model->optionProperties) {
    foreach ($model->optionProperties as $v) {
        $title = $v->title;
        $html = "<p><div class='row'><div class='col-xs-11'>";
        $html .= Html::hiddenInput('dataProp[id][]', $v->id);
        $html .= Html::input('hidden', 'dataProp[title][]', $title, ['class' => 'form-control', 'readonly' => true]);
        $html .= $title;
        $html .= "</div><div class='col-xs-1'>";
        $html .= Html::button('x', ['class' => 'remove-prop btn btn-xs btn-danger']);
        $html .= "</div></div></p>";
        $itemsProp[] = ['content' => $html];
    }
}


?>

<div class="item panel panel-default"><!-- widgetBody -->
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-3">
                <h3 class="panel-title">คุณสมบัติผู้สมัคร</h3>
            </div>
            <div class="col-xs-10 col-sm-7 col-md-8">
                <?php
                echo Typeahead::widget([
                    'name' => 'search_property',
                    'options' => ['placeholder' => 'พิมพ์ค้นหา ...', 'id' => 'prop-text'],
                    'scrollable' => true,
                    'pluginOptions' => ['highlight' => true],
                    'dataset' => [
                        [
                            'remote' => Url::to(['property-list']),
                            'display' => 'title',
                            'limit' => 10
                        ]
                    ],
                    'pluginEvents' => [
                        "typeahead:select" => 'function(index,item){ 
                      var btnDel = " <button type=\"button\" class=\"btn btn-xs btn-danger\" onclick=\"if(confirm(\'ต้องการลบรายการนี้ใชหรือไม่\')){$(this).parent().parent().remove();}\">x</button>";
                      var res = $("#list-property");
                      var li = "<li class=\"row\"><p></p><div class=\"col-xs-11\">";
                      li += "<input type=\"hidden\" name=\"dataProp[id][]\" value=\""+item.id+"\">";
                      li += "<input type=\"hidden\" name=\"dataProp[title][]\" class=\"form-control\" value=\""+item.title+"\">";
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
                <?= Html::button('+', ['class' => 'add-prop btn btn-success']) ?>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <?= Sortable::widget([
            'items' => $itemsProp,
            'options' => ['tag' => 'ul', 'id' => 'list-property', 'class' => 'list-unstyled'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
        ]);
        ?>

    </div>
</div>



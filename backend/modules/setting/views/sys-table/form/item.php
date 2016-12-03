<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use yii\helpers\Html;

?>
    <div id="panel-job-values" class="panel panel-default">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'data_wrapper',
            'widgetBody' => '.form-data-body',
            'widgetItem' => '.form-data-item',
            'min' => 1,
            'insertButton' => '.data-add-item',
            'deleteButton' => '.data-delete-item',
            'model' => $modelsItem[0],
            'formId' => 'table-form',
            'formFields' => [
                'code',
                'name',
                'status'
            ],
        ]); ?>
        <table class="table table-bordered table-striped margin-b-none">
            <thead>
            <tr>
                <th style="text-align: center"></th>
                <th>Code</th>
                <th>ชื่อ</th>
                <th>Status</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="form-data-body">
            <?php foreach ($modelsItem as $index => $menu): ?>
                <tr class="form-data-item" style="height: 30px;">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]code")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]name")
                            ->label(false)
                            ->widget(\yii\jui\AutoComplete::className())
                        ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]status")
                            ->label(false)
                            ->textInput(['placeholder'=>'0 or 1']); ?>
                    </td>
                    <td class="vcenter">

                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="data-delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i>
                        </button>
                        <?php
                        if( ! $menu->isNewRecord){
                            echo Html::activeHiddenInput($menu,"[{$index}]id");
                        }

                        ?>


                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="5"></td>

                <td class="text-center vcenter">
                    <button type="button" class="data-add-item btn btn-success btn-xs">
                        <span class="fa fa-plus"></span>
                    </button>
                </td>

            </tr>

            </tfoot>

        </table>

        <?php DynamicFormWidget::end(); ?>

    </div>
<?php
$js =  <<<'EOD'
$(".data_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".data_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".data_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".data_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".data_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});

var fixHelperSortable = function(e, ui) {
    ui.children().each(function() {
        $(this).width($(this).width());
    });
    return ui;
};

$(".form-data-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
   // helper: fixHelperSortable,
    update: function(ev){
        $(".data_wrapper").yiiDynamicForm("updateContainer");
    }
});
EOD;
JuiAsset::register($this);
$this->registerJs($js);

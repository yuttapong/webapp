<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\jui\JuiAsset;
use kartik\widgets\Select2;
use yii\helpers\Html;
?>
    <div id="panel-job-values" class="panel panel-default">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'job_wrapper',
            'widgetBody' => '.form-job-body',
            'widgetItem' => '.form-job-item',
            'min' => 1,
            'insertButton' => '.job-add-item',
            'deleteButton' => '.job-delete-item',
            'model' => $modelsMenu[0],
            'formId' => 'module-form',
            'formFields' => [
                'position_name',
                'company',
                'address',
                'reason_leaving'
            ],
        ]); ?>
        <table class="table table-bordered table-striped margin-b-none">
            <thead>
            <tr>
                <th style="text-align: center"></th>
                <th class="required">ชื่อเมนู</th>
                <th>Route</th>
                <th>Parent</th>
                <th>Icon</th>
                <th>Is header ?</th>
                <th width="10">Active</th>
            </tr>
            </thead>
            <tbody class="form-job-body">
            <?php foreach ($modelsMenu as $index => $menu): ?>
                <tr class="form-job-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]name")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]route")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">

                        <?=$form->field($menu, "[{$index}]parent")
                            ->dropDownList($menu->getArrayParent(),['prompt'=>'---'])
                            ->label(false)
                        ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]icon")
                            ->label(false)->textInput(['placeholder' => 'fa fa-home'])
                        ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]is_header")
                            ->label(false)->textInput(['placeholder' => '0 or 1'])
                        ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($menu, "[{$index}]active")
                            ->label(false)->widget(\kartik\switchinput\SwitchInput::className())
                        ?>
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="job-delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i>
                        </button>
                        <?php if (!$menu->isNewRecord): ?>
                            <?=Html::activeHiddenInput($menu, "[{$index}]id"); ?>
                        <?php endif; ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="7"></td>

                <td class="text-center vcenter">
                    <button type="button" class="job-add-item btn btn-success btn-xs">
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
$(".job_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".job_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".job_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".job_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".job_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});

$(".form-job-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
   // helper: fixHelperSortable,
    update: function(ev){
        $(".job_wrapper").yiiDynamicForm("updateContainer");
    }
});
EOD;
JuiAsset::register($this);
$this->registerJs($js);
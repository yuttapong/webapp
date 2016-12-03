<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
$modelRv = new \backend\modules\org\models\OrgReasonForLeaving();
?>


    <div id="panel-option-values" class="panel panel-default">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'rs_wrapper',
            'widgetBody' => '.form-rs-body',
            'widgetItem' => '.form-rs-item',
            'min' => 1,
            'insertButton' => '.rs-add-item',
            'deleteButton' => '.rs-delete-item',
            'model' => $modelsReasonLeaving[0],
            'formId' => 'personnel-form',
            'formFields' => [
                'note',
            ],
        ]); ?>
        <table class="table table-bordered table-striped margin-b-none">
            <thead>
            <tr>
                <th style="text-align: center"></th>
                <th><?=Html::activeLabel($modelRv,'note')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="form-rs-body">
            <?php foreach ($modelsReasonLeaving as $index => $rs): ?>
                <tr class="form-rs-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($rs, "[{$index}]note")
                            ->label(false)
                            ->textInput(); ?>

                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="rs-delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i>
                        </button>
                        <?php
                        if( ! $rs->isNewRecord){
                            echo $form->field($rs,"[{$index}]id")->hiddenInput()->label(false);

                        }
                        ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="2"></td>

                <td class="text-center vcenter">
                    <button type="button" class="rs-add-item btn btn-success btn-xs">
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
$(".rs_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".rs_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".rs_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".rs_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".rs_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});

$(".form-rs-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
    //helper: fixHelperSortable,
    update: function(ev){
        $(".rs_wrapper").yiiDynamicForm("updateContainer");
    }
});
EOD;

$this->registerJs($js);
<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Html;
$modelEducation = new \backend\modules\org\models\OrgPersonnelEducation();
?>
    <div id="panel-education-values" class="panel panel-default">

        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'edu_wrapper',
            'widgetBody' => '.form-edu-body',
            'widgetItem' => '.form-edu-item',
            'min' => 1,
            'insertButton' => '.edu-add-item',
            'deleteButton' => '.edu-delete-item',
            'model' => $modelsEducation[0],
            'formId' => 'personnel-form',
            'formFields' => [
                'education_name',
                'branch'
            ],
        ]); ?>
        <table class="table table-bordered table-striped margin-b-none">
            <thead>
            <tr>
                <th style="text-align: center"></th>
                <th><?=Html::activeLabel($modelEducation,'sorter')?></th>
                <th><?=Html::activeLabel($modelEducation,'end_year')?></th>
                <th><?=Html::activeLabel($modelEducation,'education_name')?></th>
                <th><?=Html::activeLabel($modelEducation,'branch')?></th>
                <th><?=Html::activeLabel($modelEducation,'grade')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="form-edu-body">

            <?php foreach ($modelsEducation as $index => $modelOptionValue): ?>
                <tr class="form-edu-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]end_year")
                            ->label(false)
                            ->widget(\yii\widgets\MaskedInput::className(),[
                                    'mask' => '9999'
                            ]); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]education_name")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]branch")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelOptionValue, "[{$index}]grade")
                            ->label(false)
                            ->widget(\yii\widgets\MaskedInput::className(),[
                                'mask' => '9.99'
                            ]); ?>
                    </td>
                    <td>
                        <?php if (!$modelOptionValue->isNewRecord): ?>

                            <?= Html::activeHiddenInput($modelOptionValue, "[{$index}]id"); ?>

                        <?php endif; ?>
                    </td>

                    <td class="text-center vcenter">
                        <button type="button" class="edu-delete-item btn btn-danger btn-xs">
                            <i class="fa fa-minus"></i>
                        </button>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="6"></td>

                <td class="text-center vcenter">
                    <button type="button" class="edu-add-item btn btn-success btn-xs">
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
$(".edu_wrapper").on("beforeInsert", function(e, item) {
    console.log("beforeInsert");
});

$(".edu_wrapper").on("afterInsert", function(e, item) {
    console.log("afterInsert");
});

$(".edu_wrapper").on("beforeDelete", function(e, item) {
    if (! confirm("Are you sure you want to delete this item?")) {
        return false;
    }
    return true;
});

$(".edu_wrapper").on("afterDelete", function(e) {
    console.log("Deleted item!");
});

$(".edu_wrapper").on("limitReached", function(e, item) {
    alert("Limit reached");
});

$(".form-edu-body").sortable({
    items: "tr",
    cursor: "move",
    opacity: 0.6,
    axis: "y",
    handle: ".sortable-handle",
   // helper: fixHelperSortable,
    update: function(ev){
        $(".edu_wrapper").yiiDynamicForm("updateContainer");
    }
});
EOD;

$this->registerJs($js);
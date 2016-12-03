<?php
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
$modelWork = new \backend\modules\org\models\OrgPersonnelWork();
?>


    <div id="panel-job-values" class="panel panel-default">
        <?php DynamicFormWidget::begin([
            'widgetContainer' => 'job_wrapper',
            'widgetBody' => '.form-job-body',
            'widgetItem' => '.form-job-item',
            'min' => 1,
            'insertButton' => '.job-add-item',
            'deleteButton' => '.job-delete-item',
            'model' => $modelsWork[0],
            'formId' => 'personnel-form',
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
                <th></th>
                <th><?=Html::activeLabel($modelWork,'position_name')?></th>
                <th><?=Html::activeLabel($modelWork,'company')?></th>
                <th><?=Html::activeLabel($modelWork,'address')?></th>
                <th><?=Html::activeLabel($modelWork,'reason_leaving')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody class="form-job-body">
            <?php foreach ($modelsWork as $index => $modelJob): ?>
                <tr class="form-job-item">
                    <td class="sortable-handle text-center vcenter" style="cursor: move;">
                        <i class="fa fa-arrows"></i>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelJob, "[{$index}]position_name")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelJob, "[{$index}]company")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelJob, "[{$index}]address")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="vcenter">
                        <?= $form->field($modelJob, "[{$index}]reason_leaving")
                            ->label(false)
                            ->textInput(); ?>
                    </td>
                    <td class="text-center vcenter">
                        <button type="button" class="job-delete-item btn btn-danger btn-xs"><i class="fa fa-minus"></i>
                        </button>
                        <?php
                        if( ! $modelJob->isNewRecord){
                            echo $form->field($modelJob,"[{$index}]id")->hiddenInput()->label(false);
                        }
                        ?>

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

            <tfoot>

            <tr>

                <td colspan="6"></td>

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

$this->registerJs($js);
<?php
use kartik\helpers\Html;
use kartik\form\ActiveForm;
use kartik\tabs\TabsX;
use yii\jui\JuiAsset;
use kartik\select2\Select2;

?>

<?php
$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_VERTICAL,
    'id' => 'personnel-form',
    //'enableAjaxValidation' => true,
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>

<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'บันทึก' : 'บันทึก', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?= $form->errorSummary($model) ?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3">
        <?php
        if ($model->photo) {
            echo Html::img($model->photoUrl, ['class' => 'img img-responsive img-thumbnail']);
            if ($model->code)
                echo Html::tag('div', Html::activeLabel($model, 'code') . '<br>' . Html::badge($model->code));
        }
        ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-3">
     <div class="row">
         <div class="col-md-4"><?=Html::activeLabel($model,'persernel_id')?></div>
         <div class="col-md-8"><?=$model->personnel->fullnameTH?></div>
     </div>
    </div>

</div>

<div class="row">
    <div class="col-xs-5 col-md-6">
        <?php
        echo $model->showApplyPosition;
        ?>
    </div>
    <div class="col-xs-7 col-md-6">

    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <?php //echo $form->field($model, 'position_name')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'positionApply')
            ->widget(\kartik\widgets\Select2::className(), [
                'data' => $model->getPositionAvailableList(),
                'options' => [
                    'multiple' => true
                ],
                'addon' => [
                    'contentAfter' => 'สามารถเลือกได้หลายตำแหน่ง'
                ]
            ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'salary_desired')->textInput(['placeholder' => 'ช่วงเงินเดือน']) ?>
    </div>
</div>


<?php
if (!$model->isNewRecord) {
    echo Html::activeHiddenInput($model, 'id');
}
?>


<?php ActiveForm::end(); ?>

<?php

JuiAsset::register($this);
?>




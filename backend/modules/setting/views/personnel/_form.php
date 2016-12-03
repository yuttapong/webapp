<?php
use yii\jui\JuiAsset;
use kartik\form\ActiveForm;
use yii\bootstrap\Html;
use kartik\tabs\TabsX;
?>

<?php $form = ActiveForm::begin([
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
<?php
$items = [
    [
        'label' => '<i class="fa fa-home"></i> ทั่วไป',
        'content' => $this->render('form/general', [
            'form' => $form,
            'model' => $model,
            'citizenAmphur' => $citizenAmphur,
            'initialPreviewPhoto'=> $initialPreviewPhoto,
            'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,
        ]),
        'active' => true
    ],
    [
        'label' => '<i class="fa fa-mortar-board"></i> การศึกษา',
        'content' => $this->render('form/education', [
            'form' => $form,
            'model' => $model,
            'modelsEducation' => $modelsEducation
        ]),
    ],
    [
        'label' => '<i class="fa fa-users"></i> ประวัติการทำงาน',
        'content' => $this->render('form/work', [
            'form' => $form,
            'model' => $model,
            'modelsWork' => $modelsWork
        ]),
    ],
    [
        'label' => '<i class="fa fa-sign-out"></i> เหตุที่ลาออก',
        'content' => $this->render('form/reason-leaving', [
            'form' => $form,
            'model' => $model,
            'modelsReasonLeaving' => $modelsReasonLeaving
        ]),
    ],
];
?>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3"><?=$form->field($model,'file')->widget(\kartik\widgets\FileInput::className(),[
            'options' => [
                'accept' => 'image/*',
                'multiple' => false
            ],
            'pluginOptions' => [
                'previewFileType' => 'image',
                // 'uploadUrl' => Url::to(['upload-photo-ajax']),
                'showUpload' => false,
                'showRemove' => true,
                'showClose' => false,
                'browseIcon' => '<i class="fa fa-image"></i> ',
                // 'browseClass' => 'btn btn-primary btn-block',
                'uploadExtraData' => [
                    'ref' => $model->id,
                ],
                'initialCaption' => "Photo",
                'overwriteInitial' => true,
                'initialPreviewShowDelete' => false,
                'initialPreview' => $initialPreviewPhoto,
                'initialPreviewConfig' => $initialPreviewPhotoConfig,
                'maxFileSize' => 2000,
                'autoReplace' => true,
                'maxFileCount' => 1,
            ],
        ])?></div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'firstname_th')->textInput()?>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'lastname_th')->textInput()?>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'code')->textInput()?>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'work_type')->dropDownList($model->workTypeItems)?>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'work_status')->dropDownList($model->workStatusItems)?>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-3">
        <?=$form->field($model,'active')->widget(\kartik\widgets\SwitchInput::className())?>
    </div>
</div>


<?php
 TabsX::widget([
    'items' => $items,
    'position' => TabsX::POS_ABOVE,
    'encodeLabels' => false,
    'bordered' => false,
]);
?>


<?php
if( ! $model->isNewRecord){
    echo Html::activeHiddenInput($model,'id');
}
?>


<?php ActiveForm::end(); ?>

<?php

JuiAsset::register($this);
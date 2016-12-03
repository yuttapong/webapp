<?php
use kartik\helpers\Html;
use kartik\form\ActiveForm;
use kartik\tabs\TabsX;
use yii\jui\JuiAsset;

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
    <div class="col-xs-12 col-sm-8 col-md-10">
        <p align="center">
            <?=$modelManpower->companyName?><br>
            <?=$modelManpower->company->address_full?>

        </p>

    </div>
    <div class="col-xs-12 col-sm-4 col-md-2">
        <?php echo Html::img($model->photoUrl,['class' => 'img img-responsive img-thumbnail'])?>
    </div>
</div>

<div class="row">
    <div class="col-xs-5 col-md-6">     <?php echo $form->field($model,'imageFile')->fileInput()?></div>
    <div class="col-xs-7 col-md-6">
        <?php
        if($model->code)
            echo Html::tag('div',Html::activeLabel($model,'code').'<br>'.Html::badge($model->code));
        ?>
    </div>
</div>


<div class="row">
<div class="col-md-6">
    <?php echo $form->field($model,'position_name')->textInput(['readonly' => true])?>
</div>
    <div class="col-md-6">
        <?=$form->field($model,'salary_desired')->textInput(['placeholder'=>'ช่วงเงินเดือน'])?>
    </div>
</div>

<?php
$items = [
    [
        'label' => '<i class="fa fa-home"></i> ทั่วไป',
        'content' => $this->render('form/general', [
            'form' => $form,
            'modelPersonnel' => $modelPersonnel,
            'citizenAmphur' => $citizenAmphur,
            'initialPreviewPhoto'=> $initialPreviewPhoto,
            'initialPreviewPhotoConfig'=>$initialPreviewPhotoConfig,
        ]),
        'active' => true
    ],
    [
        'label' => '<i class="fa fa-mortar-board"></i> ประวัติการศึกษา',
        'content' => $this->render('form/education', [
            'form' => $form,
            'modelPersonnel' => $modelPersonnel,
            'modelsEducation' => $modelsEducation
        ]),
    ],
    [
        'label' => '<i class="fa fa-users"></i> ประวัติการทำงาน',
        'content' => $this->render('form/work', [
            'form' => $form,
            'modelPersonnel' => $modelPersonnel,
            'modelsWork' => $modelsWork
        ]),
    ],
];


?>
<?php
echo TabsX::widget([
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
?>




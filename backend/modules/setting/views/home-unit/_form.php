<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\home */
/* @var $form yii\widgets\ActiveForm */
?>
<?php \yii\widgets\Pjax::begin();?>
<?php $form = ActiveForm::begin(); ?>
<?=$form->errorSummary($model)?>
<div class="home-form">

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($model, 'project_id')->dropDownList($model->getProjectItems(), ['prompt' => '------']) ?>
            <?= $form->field($model, 'type')->dropDownList(['single' => 'Single', 'middle' => 'Middle', 'edge' => 'Edge',], ['prompt' => '']) ?>
            <?= $form->field($model, 'plan_no')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'home_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= $form->field($model, 'home_price')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'land')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'use_area')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">


            <div class="panel panel-default">
                <div class="panel-heading">สถานะ</div>
                <div class="panel-body">
                    <?= $form->field($model, 'status')->radioList($model->getStatusItems()) ?>
                    <?= $form->field($model, 'home_status')->dropDownList($model->getBookingStatusItems(), ['prompt' => '--Select--']) ?>
                    <?= $form->field($model, 'compact_status')->dropDownList($model->getContractStatusItems(), ['prompt' => '--Select--']) ?>
                    <?= $form->field($model, 'transfer_status')->dropDownList($model->getTransferStatusItems(), ['prompt' => '--Select--']) ?>
                </div>
            </div>

        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">ข้อมูลลูกค้า</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-10 col-sm-10 col-md-10">

                                    <?= $form->field($model, 'customer_name')->textInput([
                                        'id' => 'customer-name',
                                        'class' => 'form-control', 'readonly' => true
                                    ])->label(false) ?>
                                </div>
                                <div class="col-xs-1 col-sm-1 col-md-1">
                                     <?=Html::a('<i class="fa  fa-search"></i>',['model-search-customer'],[
                                         'class'=>'btn btn-default btn-find-customer',
                                         'data-title' => 'ค้นหาลูกค้า',
                                     ])?>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <?= $form->field($model, 'customer_id')->textInput([
                                'required' => true,
                                'placeholder' => 'Customer ID',
                                'readonly' => true,
                            ]) ?>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>


</div>
<?php ActiveForm::end(); ?>




<?php
Modal::begin([
    'options' => [
        'id' => 'modal-customer',
    ],
    'toggleButton' => [
        'label' => '<i class="fa fa-search"></i> ค้นหา',
        'class' => 'btn btn-default'
    ],
    'closeButton' => [
        'label' => 'Close',
        'class' => 'btn btn-danger btn-sm pull-right',
    ],
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]

]);
/*
$this->render('modal/find-customer', [
        'model' => new \backend\modules\crm\models\Customer(),
        'dataProviderCustomer' => $dataProviderCustomer,
        'searchModelCustomer' => $searchModelCustomer,
    ]
);
*/
echo '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>';
Modal::end();
?>
<?php \yii\widgets\Pjax::end();?>

<?php
$js = <<< JS
  $("#home-customer_name").on("blur", function(e){
        var name = $(this).val();
        if(name==""){
            $("#home-customer_id").val("");
        }
  });
  $(".btn-add-customer").on("click", function(){
       $("#modal-customer").modal("show").find(".modal-body").load(link);
  });
  
    $(".btn-find-customer").on("click", function(e){
        e.preventDefault();
        var modalId = "#modal-customer";
        var link = $(this).attr("href");
        var title = $(this).data("title");
        $(modalId +" .modal-title").html("เพิ่มข้อมูลสมาชิก");
        $(modalId + " .modal-body").load(link);
        $(modalId).modal("show");
  });
JS;
$this->registerJs($js);
?>

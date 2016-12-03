<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\home */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
    <div class="home-form">

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-3">
                <?= $form->field($model, 'project_id')->dropDownList($model->getProjectItems(), ['prompt' => '------']) ?>
                <?= $form->field($model, 'type')->dropDownList(['single' => 'Single', 'middle' => 'Middle', 'edge' => 'Edge',], ['prompt' => '']) ?>
                <?= $form->field($model, 'plan_no')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'home_no')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">
                <?= $form->field($model, 'home_price')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'land')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'use_area')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-3">


                <div class="panel panel-default">
                    <div class="panel-heading">สถานะ</div>
                    <div class="panel-body">
                        <?= $form->field($model, 'status')->checkbox() ?>
                        <?= $form->field($model, 'home_status')->dropDownList($model->getBookingStatusItems(), ['prompt' => '--Select--']) ?>
                        <?= $form->field($model, 'compact_status')->dropDownList($model->getContractStatusItems(), ['prompt' => '--Select--']) ?>
                        <?= $form->field($model, 'transfer_status')->dropDownList($model->getTransferStatusItems(), ['prompt' => '--Select--']) ?>
                    </div>
                </div>

        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">ข้อมูลลูกค้า</div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-10 col-sm-11 col-md-10">
                                <?=$form->field($model,'customer_name')->textInput([
                                    'id' => 'customer-name',
                                    'class'=>'form-control','readonly'=>true
                                ])->label(false)?>
                                    </div>
                                <div class="col-xs-1 col-sm-1 col-md-2">
                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search text-muted"></span></button>
                            </div>
                            <?php
                                /*
                                $form->field($model, 'customers_name')->widget(Typeahead::className(), [
                                'options' => [
                                    'placeholder' => 'พิมชื่อลูกค้า...',
                                    'onl'
                                ],
                                'pluginOptions' => ['highlight' => true, 'minLength' => 2],
                                'pluginEvents' => [
                                    "typeahead:selected" => "function(obj, item) { $('#home-customers_id').val(item.id);  return true; }",
                                ],
                                'dataset' => [
                                    [
                                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                        'display' => 'value',
                                        'remote' => [
                                            'url' => Url::to(['customer-list']) . '?q=%QUERY',
                                            'wildcard' => '%QUERY'
                                        ]
                                    ]
                                ]
                            ]) */
                                ?>
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
      'id' =>'modal-customer',
    ],
    'toggleButton' => [
        'label' => '<i class="fa fa-plus"></i> เพิ่มรายชื่อลูกค้า',
        'class' => 'btn btn-default btn-xs'
    ],
    'closeButton' => [
        'label' => 'Close',
        'class' => 'btn btn-danger btn-sm pull-right',
    ],
    'size' => 'modal-lg',
]);
echo $this->render('modal/addcustomer', ['model' => new \backend\modules\crm\models\Customer()]);
Modal::end();
?>


<?php
echo $this->registerJs('
  $("#home-customers_name").on("blur", function(e){
        var name = $(this).val();
        if(name==""){
            $("#home-customers_id").val("");
        }
  });
  $(".btn-add-customer").on("click", function(){
       $("#modal-customer").modal("show").find(".modal-body").load(link);
  });
');
?>

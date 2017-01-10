<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\modules\purchase\models\Unit;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\TabularInput;
use unclead\multipleinput\TabularColumn;
use unclead\multipleinput\examples\models\ExampleModel;
use yii\helpers\Url;
use mdm\upload\UploadBehaviorl;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */
/* @var $form yii\widgets\ActiveForm */
//echo '<pre>';
//print_r(Unit::dataList());
//echo '</pre>';
?>



<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>
<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6">
        <?php
        if( ! $model->isNewRecord) {
            echo  Html::img(Url::to(['/file','id'=>$model->file_id]),['width'=> 120]);
        }
        ?>
        <?=$form->field($model,'photo')->fileInput()?>
        <?= $form->field($model, 'categories_id')->widget(\kartik\select2\Select2::className(), [
            'data' => \backend\modules\purchase\models\Categories::getCategoryItems(),
            'language' => 'th',
            'options' => [
                'placeholder' => 'เลือกหมวดหมู่ ...',
                // 'multiple' => true
            ],
            'pluginOptions' => [
                'allowClear' => true
            ]
        ]) ?>
        <?= $form->field($model, 'type')->dropDownList(['set' => 'Set', 'one' => 'One', 'unit' => 'Unit',], ['prompt' => '']) ?>
        <?php
        echo $form->field($model, 'unit_id')->widget(Select2::classname(), [
            'data' => Unit::getDataList(),
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
        ?>

        <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->widget(\kartik\switchinput\SwitchInput::className()) ?>
    </div>
    <div class="col-sm-12 col-sm-6 col-md-6">


        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>



        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>




        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>



    </div>
</div>


<!-- ตารางเพิ่มข้อมูลราคาสินค้า-->
<div class="row">
    <div class="col-md-12">
        <?php
        echo $form->field($model, 'prices')->widget(MultipleInput::className(), [
            'id' => 'multiple-input',
            'allowEmptyList' => false,
            'max' => 10,
            'addButtonPosition' => MultipleInput::POS_FOOTER,
            'columns' => [
                [
                    'name' => 'id',
                    'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_HIDDEN_INPUT,
                    'title' => 'Price ID',
                    'value' => function ($data) {
                        return $data['id'];
                    }
                ],
                [
                    'name' => 'vendor_id',
                    'type' => Select2::className(),
                    'value' => function ($data) {
                        return $data['vendor_id'];
                    },
                    'title' => 'ร้านค้า',
                    'enableError' => true,
                    'options' => [
                        'id' => uniqid(),
                        'class' => 'new',
                        'data' => \backend\modules\purchase\models\Vendor::getVendorItems(),
                        'pluginOptions' => [
                            'tags' => true,
                            'allowClear' => true,
                    ],
                    ],
                ],
                [
                    'name' => 'price',
                    'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
                    'enableError' => true,
                    'title' => 'ราคา',
                    'options' => [
                        'class' => 'input-priority'
                    ]
                ],
                [
                    'name'  => 'due_date',
                    'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
                    'title' => 'จำนวนวันที่จัดส่ง',
                    'headerOptions' => [
                        'style' => 'width: 120px;',
                        'class' => 'day-css-class'
                    ],
                    'options' => [
                        'class' => 'form-control',
                        'mask' => '999999'
                    ]
                ],
                [
                    'name'  => 'status',
                    'type' => \kartik\switchinput\SwitchInput::className(),
                    'title' => 'Status',
                    'headerOptions' => [
                        'style' => 'width: 250px;',
                        'class' => 'day-css-class'
                    ]
                ],
            ]
        ]);

        ?>

        <?php

        /*
        TabularInput::widget([
            'models' => $modelPrice,
            'form' => $form,
            'attributeOptions' => [
                'enableAjaxValidation' => true,
                'enableClientValidation' => false,
                'validateOnChange' => false,
                'validateOnSubmit' => true,
                'validateOnBlur' => false,
            ],
            'columns' => [
                [
                    'name' => 'id',
                    'type' => TabularColumn::TYPE_HIDDEN_INPUT
                ],
                [
                    'name' => 'vendorid',
                    'title' => 'ร้านค้า',
                    'type' => TabularColumn::TYPE_TEXT_INPUT,
                    'attributeOptions' => [
                        'enableClientValidation' => true,
                        'validateOnChange' => true,
                    ],
                    'enableError' => true
                ],
                [
                    'name' => 'price',
                    'title' => 'ราคา',
                ],
            ],
        ])
        */
        ?>

    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>


<?php

/*$this->registerJs(' $("#inventory-prices").on("afterAddRow", function(e){
       console.log("test:", e.timeStamp); 
    }); 
    $.fn.init_change = function(){ 
    var product_id = $(this).val(); 
    $.get( "' . Url::toRoute('vendor-detail') . '", { id: product_id }, 
    function (data) { var result = data.split("-"); 
     $(".field-order-items-"+sid[2]+"-product_name").text(result[0]); 
     $(".field-order-items-"+sid[2]+"-price").text(result[1]); } ); };
    ');*/

$js = <<<JS
jQuery('#inventory-prices').on('afterInit', function(){
    console.log('calls on after initialization event');
}).on('beforeAddRow', function(e) {
    console.log('calls on before add row event');
}).on('afterAddRow', function(e) {
    console.log('calls on after add row event');
}).on('beforeDeleteRow', function(e, row){
    // row - HTML container of the current row for removal.
    // For TableRenderer it is tr.multiple-input-list__item
    console.log('calls on before remove row event.');
      console.log(row);
    return confirm('Are you sure you want to delete row?')
}).on('afterDeleteRow', function(e, row){
    console.log('calls on after remove row event');
    console.log(row);
});
JS;
$this->registerJs($js);
?>


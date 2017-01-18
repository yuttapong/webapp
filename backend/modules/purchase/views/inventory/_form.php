<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;
use backend\modules\purchase\models\Unit;
use common\siricenter\multipleinput\src\TabularColumn;
use common\siricenter\multipleinput\src\TabularInput;
use common\siricenter\multipleinput\src\MultipleInput;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $form = ActiveForm::begin([
    'id' => 'tabular-form',
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'validateOnChange' => false,
    'validateOnSubmit' => true,
    'validateOnBlur' => false,
    'options' => [
        'enctype' => 'multipart/form-data'
    ]
]); ?>
<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6">
        <?php
        echo Html::img($model->imageUrl, ['class' => 'img img-responsive img-thumbnail', 'width' => '250']);
        ?>
        <?= $form->field($model, 'photo')->fileInput() ?>
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
            'id' => 'inventory-prices',
            'allowEmptyList' => false,
            'max' => 10,
            'addButtonPosition' => MultipleInput::POS_FOOTER,
            'rowOptions' => [
                'id' => 'row-{multiple_index_inventory-prices}',
            ],
            'columns' => [
                [
                    'name' => 'id',
                    'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_TEXT_INPUT,
                    'title' => 'Price ID',
                ],
                [
                    'name' => 'vendor_id',
                    // 'type' => \unclead\multipleinput\MultipleInputColumn::TYPE_DROPDOWN,
                    'type' => Select2::className(),
                    'title' => 'ร้านค้า',
                    'enableError' => true,
                    //  'items' => \backend\modules\purchase\models\Vendor::getVendorItems(),
                    'options' => [
                        'data' => \backend\modules\purchase\models\Vendor::getVendorItems(),
                        'pluginOptions' => [
                            'placeholder' => 'Select a state ...',
                            'allowClear' => true,
                            'escapeMarkup' => new JsExpression("function(m) { return m; }"),
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
                    'name' => 'due_date',
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
                    'name' => 'active',
                    'type' => \kartik\switchinput\SwitchInput::className(),
                    'title' => 'Active',
                    'headerOptions' => [
                        'style' => 'width: 250px;',
                        'class' => 'day-css-class'
                    ],
                ],
            ]
        ]);
        ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php
$js = <<<JS
jQuery('#inventory-prices').on('afterInit', function(){
    console.log('calls on after initialization event');
}).on('beforeAddRow', function(e) {
    console.log('calls on before add row event');
}).on('afterAddRow', function(e ) {
    console.log('calls on after add row event');
}).on('beforeDeleteRow', function(e, row){
    // row - HTML container of the current row for removal.
    // For TableRenderer it is tr.multiple-input-list__item
    console.log('calls on before remove row event.');
      var index = row.index();
      var  id = $('#inventory-prices-'+ index + '-id').val();
      var price = $('#inventory-prices-'+ index + '-price').val();
      if (id ) {
           if( confirm('Are you sure you want to delete ร้าน :  ' + id  + '/ ราคา: '+ price +'  ใช่หรือไม่')) {
                console.log(id);
                $.ajax({
                  url: 'delete-price',
                  type:'post',
                  dataType:'json',
                  data:{id:id},
                  success: function(rs) {
                    if(rs.success===1) {
                        console.log(rs.msg);
                    }else{
                        console.log(rs.msg);
                    }
                  }
                })
                return true;
           } else {
             return false;
           }
      }else{
       return true;
      }
}).on('afterDeleteRow', function(e, row){
      console.log('calls on after remove row event');
});
JS;
$this->registerJs($js);
?>


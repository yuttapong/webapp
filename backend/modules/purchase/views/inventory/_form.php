<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\purchase\models\Unit;
use unclead\multipleinput\MultipleInput;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */
/* @var $form yii\widgets\ActiveForm */
//echo '<pre>';
//print_r(Unit::dataList());
//echo '</pre>';
?>



    <?php $form = ActiveForm::begin(); ?>


<div class="row">
    <div class="col-sm-12 col-sm-6 col-md-6">
        <?= $form->field($model, 'categories_id')->widget(\kartik\select2\Select2::className(),[
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
        <?= $form->field($model, 'type')->dropDownList([ 'set' => 'Set', 'one' => 'One', 'unit' => 'Unit', ], ['prompt' => '']) ?>
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
    </div>
    <div class="col-sm-12 col-sm-6 col-md-6">


        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>



        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>




        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

        <?= $form->field($model, 'status')->textInput() ?>

    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php
        $modelPrice = new \backend\modules\purchase\models\InventoryPrice;
        ?>
        <?= $form->field($model, 'prices')->widget(MultipleInput::className(), [
            'max' => 4,
            'columns' => [
                [
                    'name'  => 'vendor_id',
                    'type'  => 'dropDownList',
                    'title' => 'ร้านค้า',
                    'defaultValue' => 1,
                    'items' => [
                        1 => 'User 1',
                        2 => 'User 2'
                    ]
                ],
                [
                    'name'  => 'price',
                    'enableError' => true,
                    'title' => 'ราคา',
                    'options' => [
                        'class' => 'input-priority'
                    ]
                ],
                [
                    'name'  => 'status',
                    'type'  => 'static',
                    'value' => function($data) {
                        /*
                        if($data->status===1)
                            return Html::tag('span','Active',['class'=>'label label-success']);
                        else
                            return Html::tag('span','Inactive',['class'=>'label label-default']);
                        */
                    },
                    'headerOptions' => [
                        'style' => 'width: 70px;',
                    ]
                ]
            ]
        ]);
        ?>
    </div>
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>



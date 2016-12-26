<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\purchase\models\Unit;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */
/* @var $form yii\widgets\ActiveForm */
//echo '<pre>';
//print_r(Unit::dataList());
//echo '</pre>';
?>

<div class="inventory-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categories_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->dropDownList([ 'set' => 'Set', 'one' => 'One', 'unit' => 'Unit', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


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

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

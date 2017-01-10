<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\InventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form'
        ]
    ]); ?>
    <?= $form->field($model, 'id') ?>
    <?= $form->field($model, 'categories_id')->widget(\kartik\select2\Select2::className(),[
        'data' => \backend\modules\purchase\models\Categories::getCategoryItems(),
        'language' => 'th',
        'options' => ['placeholder' => 'เลือกหมวดหมู่ ...'],
        'pluginOptions' => [
            'allowClear' => true
        ]
    ]) ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?php echo $form->field($model, 'status')->dropDownList([0=>'Inactive',1=>'Active'],['prompt'=>'--Status--']) ?>

    <?php // echo $form->field($model, 'unit') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_at') ?>

    <?php // echo $form->field($model, 'create_by') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'update_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Home */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="home-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'project_id')->textInput() ?>

    <?= $form->field($model, 'home_plan_id')->textInput() ?>

    <?= $form->field($model, 'plan_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList([ 'single' => 'Single', 'middle' => 'Middle', 'edge' => 'Edge', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'home_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'land')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'use_area')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'home_status')->textInput() ?>

    <?= $form->field($model, 'compact_status')->textInput() ?>

    <?= $form->field($model, 'transfer_status')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

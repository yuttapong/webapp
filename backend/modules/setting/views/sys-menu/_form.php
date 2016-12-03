<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SysMenu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-menu-form">

    <?php $form = ActiveForm::begin(
    [
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
    ]

    ); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'module_id')
                ->dropDownList(\common\models\SysModule::getArrayModule()) ?>
            <?=$form->field($model, 'is_header')
                ->widget(\kartik\checkbox\CheckboxX::classname(), [
                    'autoLabel' => true])
                ->label(false);
            ?>
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'parent')
                ->dropDownList(\common\models\SysMenu::getArrayParent(),
                    ['prompt' => '-Select-']) ?>
            <?= $form->field($model, 'route')->textInput(['maxlength' => true,'placeholder'=>'/module/controller/action']) ?>
        </div>
        <div class="col-md-6">


            <?= $form->field($model, 'order')->textInput() ?>

            <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>



            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            <?=$form->field($model, 'active')
                ->widget(\kartik\checkbox\CheckboxX::classname(), [
                    'autoLabel' => true])
                ->label(false);
            ?>

        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

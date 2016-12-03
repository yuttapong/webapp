<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SysModuleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-module-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' =>['class'=> 'form-inline'],
    ]); ?>


    <?= $form->field($model, 'name_en') ?>

    <?= $form->field($model, 'name_th') ?>

    <?php // echo $form->field($model, 'create_id') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'table_id') ?>

    <?php // echo $form->field($model, 'bd_id') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

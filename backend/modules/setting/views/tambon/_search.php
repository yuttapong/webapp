<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\SysTambonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-tambon-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'province_id') ?>

    <?= $form->field($model, 'amphur_id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name_th') ?>

    <?php // echo $form->field($model, 'amphur_code') ?>

    <?php // echo $form->field($model, 'province_code') ?>

    <?php // echo $form->field($model, 'geography_id') ?>

    <?php // echo $form->field($model, 'zip_cpde') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'master_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

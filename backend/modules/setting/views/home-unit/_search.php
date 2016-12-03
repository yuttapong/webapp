<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\HomeUnitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="home-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'home_plan_id') ?>

    <?= $form->field($model, 'plan_no') ?>

    <?= $form->field($model, 'home_no') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'home_prices') ?>

    <?php // echo $form->field($model, 'land') ?>

    <?php // echo $form->field($model, 'use_area') ?>

    <?php // echo $form->field($model, 'home_status') ?>

    <?php // echo $form->field($model, 'compact_status') ?>

    <?php // echo $form->field($model, 'transfer_status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'date_insurance') ?>

    <?php // echo $form->field($model, 'customers_id') ?>

    <?php // echo $form->field($model, 'customers_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformJobSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inform-job-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'inform_fix_id') ?>

    <?= $form->field($model, 'list') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'job_list_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'responsible_id') ?>

    <?php // echo $form->field($model, 'responsible_name') ?>

    <?php // echo $form->field($model, 'job_status') ?>

    <?php // echo $form->field($model, 'pate_price') ?>

    <?php // echo $form->field($model, 'net_price') ?>

    <?php // echo $form->field($model, 'apprever_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

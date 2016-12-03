<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\ListAppreverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-apprever-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'inform_fix_id') ?>

    <?= $form->field($model, 'approver_user_id') ?>

    <?= $form->field($model, 'approver_seq') ?>

    <?= $form->field($model, 'user_next_id') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'approval_status') ?>

    <?php // echo $form->field($model, 'table_name') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\SendDocumentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="send-documents-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'table_name') ?>

    <?= $form->field($model, 'table_key') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'send_user_id') ?>

    <?php // echo $form->field($model, 'send_at') ?>

    <?php // echo $form->field($model, 'send_user_name') ?>

    <?php // echo $form->field($model, 'recipient_user_id') ?>

    <?php // echo $form->field($model, 'recipient_user_name') ?>

    <?php // echo $form->field($model, 'recipient_at') ?>

    <?php // echo $form->field($model, 'option') ?>

    <?php // echo $form->field($model, 'is_khow') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

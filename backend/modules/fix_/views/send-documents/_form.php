<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\SendDocuments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="send-documents-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'table_key')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'send_user_id')->textInput() ?>

    <?= $form->field($model, 'send_at')->textInput() ?>

    <?= $form->field($model, 'recipient_user_id')->textInput() ?>

    <?= $form->field($model, 'recipient_at')->textInput() ?>

    <?= $form->field($model, 'option')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'is_khow')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

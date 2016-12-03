<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
    ]); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    <div class="row">
      <div class="col-lg-6">
          <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
      </div>
      <div class="col-lg-6">
        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
      </div>
    </div>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'readonly'=>true]) ?>

    <div class="form-group">
        <?= Html::submitButton('<i class="glyphicon glyphicon-pencil"></i> '. Yii::t('app', 'Update'), ['class' => 'btn btn-success btn-lg']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;



/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */

?>
<div class="user-form col-xs-12 col-md-5">
    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_VERTICAL,
    ]); ?>
    <?=$form->field($model, 'avatar')->widget('maxmirazh33\image\Widget');?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true,'readonly'=>true]) ?>

          <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true,'readonly'=>true]) ?>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i> '. Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

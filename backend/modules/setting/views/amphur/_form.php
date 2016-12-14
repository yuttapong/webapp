<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SysAmphur */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-amphur-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'geography_id')->textInput() ?>

    <?= $form->field($model, 'province_code')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'master_id')->textInput(['maxlength' => true]) ?>

    <?=$form->field($model, 'active')
        ->widget(\kartik\checkbox\CheckboxX::classname(), [
            'autoLabel' => true])
        ->label(false);
    ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
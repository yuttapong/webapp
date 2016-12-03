<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SysBasicData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-basic-data-form  col-md-4">
    <div class="well">

        <?php $form = ActiveForm::begin(); ?>

        <?=$form->field($model, 'table_id')
            ->dropDownList(\common\models\SysTable::getArrayTable(),['prompt'=>'-Select-'])?>

        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'status')->widget(\kartik\checkbox\CheckboxX::classname(), [
            'autoLabel' => true
        ])->label(false);
        ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

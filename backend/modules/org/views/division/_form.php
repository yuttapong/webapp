<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\orgDivision */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-division-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>







    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?=Html::a('ยกเลิก',['index'],['class'=> 'btn btn-default'])?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

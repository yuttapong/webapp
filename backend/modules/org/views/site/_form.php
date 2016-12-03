<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrgSite */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-site-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'site_type')->dropDownList(['office'=>'Office','project'=>'Project'],['prompt'=>'----'])?>
    <?= $form->field($model, 'site_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'company_id')->dropDownList($model->arrayCompany) ?>
    <?=$form->field($model,'active')->widget(\kartik\widgets\SwitchInput::className())?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

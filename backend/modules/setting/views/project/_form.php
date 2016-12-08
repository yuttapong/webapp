<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\project */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'site_id')->dropDownList($model->getSiteItems(),['prompt'=>'---Select-']) ?>

    <?= $form->field($model, 'company_id')->dropDownList($model->getCompanyItems(),['prompt'=>'---Select-']) ?>

    <?= $form->field($model, 'status')->radioList($model->getStatusItems())?>

    <?= $form->field($model, 'type')->dropDownList([ 'TownHome' => 'TownHome', 'Townhouse' => 'Townhouse', 'House' => 'House', ], ['prompt' => '']) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a( 'Cancel',['index'], ['class' =>  'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

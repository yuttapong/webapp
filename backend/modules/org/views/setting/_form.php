<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgJobOption */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="org-job-option-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'position_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\backend\modules\org\models\OrgPosition::find()->orderBy('_id')->asArray()->all(), '_id', '_id'),
        'options' => ['placeholder' => 'Choose Org position'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <?= $form->field($model, '_type')->dropDownList([ 'responsibility' => 'Responsibility', 'property' => 'Property', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Title']) ?>

    <?= $form->field($model, 'create_at')->textInput(['placeholder' => 'Create At']) ?>

    <?= $form->field($model, 'create_id')->textInput(['placeholder' => 'Create']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

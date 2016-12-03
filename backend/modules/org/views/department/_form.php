<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\orgDepartment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-department-form">

    <?php $form = ActiveForm::begin([
    ]); ?>

    <?= $form->field($model, 'division_id')
        ->dropDownList($model->getDivisionList(),['prompt'=>'-Select-'])?>
    <?= $form->field($model, 'part_id')
        ->dropDownList($model->getPartList(),['prompt'=>'-Select-'])?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
     <?=Html::a('ยกเลิก',['departments','part_id'=>$model->part_id],['class'=> 'btn btn-default'])?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

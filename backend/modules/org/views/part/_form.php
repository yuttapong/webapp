<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\orgPart */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="org-part-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'division_id')
        ->dropDownList(\backend\modules\org\models\OrgDivision::getDivisionList())?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?=Html::a('ยกเลิก',['parts','division_id'=>$model->division_id],['class'=> 'btn btn-default'])?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

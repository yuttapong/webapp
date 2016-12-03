<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model backend\models\SysTable */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-table-form">

    <?php $form = ActiveForm::begin([
        'id' => 'table-form'
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->widget(CheckboxX::classname(), [
        'autoLabel'=>true
    ])->label(false);
    ?>

     <?=$this->render("form/item",[
         'model' => $model,
         'modelsItem'=>$modelsItem,
         'form'=>$form
     ])?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use karpoff\icrop\CropImageUpload;

/* @var $this yii\web\View */
/* @var $model backend\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>
    <?=$form->errorSummary($model)?>


    <?= $form->field($model, 'photo')->widget(CropImageUpload::className()) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>





    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>
            </div>
        </div>
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-6">

        <?= $form->field($model, 'roles')->checkboxList($model->getAllRoles()) ?>

        <?= $form->field($model, 'status')->radioList($model->getItemStatus()) ?>
    </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>


        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>

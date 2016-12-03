<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\QuestionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="survey-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'module_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'owner') ?>

    <?= $form->field($model, 'realm') ?>

    <?php // echo $form->field($model, 'public') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'subtitle') ?>

    <?php // echo $form->field($model, 'info') ?>

    <?php // echo $form->field($model, 'theme') ?>

    <?php // echo $form->field($model, 'thanks_page') ?>

    <?php // echo $form->field($model, 'thank_head') ?>

    <?php // echo $form->field($model, 'thank_body') ?>

    <?php // echo $form->field($model, 'changed') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

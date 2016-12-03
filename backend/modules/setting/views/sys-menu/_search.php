<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\SysMenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-menu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'module_id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'parent') ?>

    <?= $form->field($model, 'route') ?>

    <?php // echo $form->field($model, 'order') ?>

    <?php // echo $form->field($model, 'data') ?>

    <?php // echo $form->field($model, 'table_id') ?>

    <?php // echo $form->field($model, 'table_key') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

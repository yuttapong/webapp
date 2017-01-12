<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\InventorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inventory-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'class' => 'form-virtical'
        ]
    ]); ?>
    <?php $form->field($model, 'id') ?>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'categories_id')->widget(\kartik\select2\Select2::className(),[
                'data' => \backend\modules\purchase\models\Categories::getCategoryItems(),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกหมวดหมู่ ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
            <?php $form->field($model, 'code') ?>
            <?= $form->field($model, 'type') ?>

        </div>
        <div class="col-sm-6">

            <?= $form->field($model, 'name') ?>

            <?php echo $form->field($model, 'status')->widget(\kartik\switchinput\SwitchInput::className()) ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-search"></i>  Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

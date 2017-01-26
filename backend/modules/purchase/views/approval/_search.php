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
    <div class="row">
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?=$form->field($model, 'code') ?>
            <?= $form->field($model, 'subject') ?>
        </div>
        <div class="col-xs-12 col-sm-4 col-md-4">
            <?= $form->field($model, 'job_list_id')->widget(\kartik\select2\Select2::className(),[
                'data' => \backend\modules\purchase\models\JobList::getJobListItem(),
                'language' => 'th',
                'options' => ['placeholder' => 'เลือกหมวดหมู่ ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ]
            ]) ?>
            <?php echo $form->field($model,'approve_status')->dropDownList($model->getStatusItem(),[
                'prompt' => '--Select--'
            ])?>
        </div>

        <div class="col-xs-12 col-sm-4 col-md-4">

            <?php echo $form->field($model, 'active')->checkbox()?>
            <div class="form-group">
                <?= Html::submitButton('<i class="fa fa-search"></i>  Search', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

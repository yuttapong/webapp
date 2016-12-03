<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="work-event-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'form',
        ]
    ]); ?>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6">


        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <?= $form->field($model, 'start_date')->widget(DateTimePicker::classname(), [
                    'type' => DateTimePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Enter event time ...'],
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy hh:ii',
                        'autoclose' => true,
                        'allowClear' => true,
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <?= $form->field($model, 'end_date')->widget(DateTimePicker::classname(), [
                    'type' => DateTimePicker::TYPE_INPUT,
                    'options' => ['placeholder' => 'Enter event time ...'],
                    'pluginOptions' => [
                        'format' => 'dd-mm-yyyy hh:ii',
                        'autoclose' => true,
                        'allowClear' => true,
                    ]
                ]);
                ?>
            </div>
        </div>


    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?= $form->field($model, 'description')->textarea(['rows' => 2]) ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

    </div>
</div>



    <?php ActiveForm::end(); ?>

</div>

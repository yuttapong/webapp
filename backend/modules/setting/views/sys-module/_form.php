<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\checkbox\CheckboxX;
use common\models\SysBasicData;

/* @var $this yii\web\View */
/* @var $model backend\models\SysModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sys-module-form">
    <?php $form = ActiveForm::begin([
            'id' => 'module-form',
        ]
    ); ?>
<?=$form->errorSummary($model)?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'slug')->textInput() ?>
            <?= $form->field($model, 'bd_id')->dropDownList(SysBasicData::getArrayGroup(2)) ?>
            <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>



            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-6">


            <?= $form->field($model, 'img')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'active')
                ->widget(\kartik\switchinput\SwitchInput::className())
                ->label(false);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-9">
            <?= $this->render("form/menu", ['form' => $form, 'modelsMenu' => $modelsMenu]) ?>
        </div>
        <div class="col-md-3">
            <?php
            echo \kartik\widgets\SideNav::widget([
                'heading' => '<i class="fa fa-star"></i> ตัวอย่างเมนู',
                'headingOptions' => ['class'=>'text-strong'],
                'type' => \kartik\sidenav\SideNav::TYPE_INFO,
                'items'=> \common\models\SysModule::getMenuForNav($model->id),

            ]);
            ?>
        </div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

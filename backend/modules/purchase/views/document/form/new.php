<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use kartik\select2\Select2;

$this->title = 'PR ทั่วไป';

?>

    <style>
        #pr {
            background-color: #d4d0c8;
            padding: 10px;
            color: #000;
            border-radius: 7px;
        }
    </style>
<?php
$form = ActiveForm::begin([]);
?>
<?= $form->errorSummary($model) ?>
    <div id="pr">


        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'subject') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?= $form->field($model, 'subject')->textInput()->label(false) ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'job_list_id') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?php

                /*                echo Select2::widget([
                                    'model' => $model,
                                    'attribute' => 'job_list_id',
                                    'data' => $joblistItem,
                                    'options' => ['placeholder' => 'Select a state ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);*/
                echo $form->field($model, 'job_list_id')->dropDownList($joblistItem, ['prompt' => '-----------']);
                ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'description') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $form->field($model, 'description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'normal'
                ])->label(false) ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'approver_user_name') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $form->field($model, 'approver_user_name')->textInput(['readonly' => true])->label(false) ?>
                <?= $form->field($model, 'approver_user_id')->hiddenInput()->label(false) ?>
            </div>
        </div>

    </div>

    <p class="form-group">
    <div align="center">
        <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    </p>


<?php ActiveForm::end(); ?>
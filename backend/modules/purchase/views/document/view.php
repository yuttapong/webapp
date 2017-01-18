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
                <?=  $model->subject?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'job_list_id') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?=  $model->job_list_id?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'description') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?=  $model->description?>
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
<hr>
<?php
 echo \backend\modules\purchase\widgets\documentapprove\DocumentApprove::widget([
     'users' => $listApprover,
     'type' =>2,
     'currentLogin' => Yii::$app->user->id,
     'options' => [
         'class' => ''
     ]
 ])
?>


<?php ActiveForm::end(); ?>
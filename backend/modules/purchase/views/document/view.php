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
    <div id="pr" class="row">
        <div class="col-md-9">


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
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'created_by') ?></div>
            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $form->field($model, 'requestBy')->textInput(['readonly' => true])->label(false) ?>
                <?= $form->field($model, 'created_by')->hiddenInput()->label(false) ?>
            </div>
        </div>

    </div>
    <div class="col-md-3">

<?php
$listApprover = $model->getActiveApproveConfirmItems();
echo \backend\modules\purchase\widgets\documentapprove\DocumentApprove::widget([
    'model' => $model,
    'attribute' => 'listapprover',
    'users' => $listApprover,
    'approved' => $model->getListUserHasApproved(),
    'url' => ['approve'],
    'options' => [
        'class' => ''
    ]
])
?>
</div>
 </div>


<?php ActiveForm::end(); ?>
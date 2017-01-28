<?php

/* @var $this yii\web\View */

use backend\modules\purchase\widgets\documentapprove\DocumentApprove;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'PR ทั่วไป';
?>


<div id="pr" class="row">

    <?php
    $form = ActiveForm::begin([]);
    ?>

    <div class="col-md-9">
        <?= $form->errorSummary($model) ?>

        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'subject') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?= $model->subject ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'job_list_id') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?= $model->jobGroup->name ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'description') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $model->description ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'created_by') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $model->createdName ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'approve_status') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?= $model->statusNameColor ?>
            </div>
        </div>

        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'cancelNote') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?php echo $form->field($model, "cancelNote")->textarea()->label(false) ?>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'cancelConfirm') ?></div>

            <div class="col-xs-12 col-sm-10 col-md-10">
                <?php echo $form->field($model, "cancelConfirm")->checkbox()->label(false)?>
            </div>
        </div>


        <p class="form-group">
        <div align="center">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        </p>


    </div>
    <?php ActiveForm::end(); ?>
    <div class="col-md-3">


        <?php
        echo DocumentApprove::widget([
            'model' => $model,
            // 'type' => DocumentApprove::TYPE_APPROVE,
            'attribute' => 'listapprover',
            'users' => $listApprover,
            'approved' => $listApproved,
            'options' => [
                'class' => ''
            ]
        ])
        ?>


    </div>


</div>


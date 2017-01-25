<?php

/* @var $this yii\web\View */

use yii\bootstrap\ActiveForm;

use yii\helpers\Html;
use backend\modules\purchase\widgets\documentapprove\DocumentApprove;
use backend\modules\purchase\models\ApproverComfirm;

$this->title = 'PR ทั่วไป';
?>
    <style>
        #pr {
            padding: 10px;
            color: #000;
            border-radius: 7px;
        }
    </style>

    <div id="pr" class="row">
        <div class="col-md-9">
            <div class="row form-group">
                <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'approve_status') ?></div>
                <div class="col-xs-10 col-sm-10 col-md-10">
                    <?= $model->statusName ?>
                </div>
            </div>

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

        </div>
        <div class="col-md-3">

            <?php
            $listApprover = $model->getActiveApproverItems();
            echo DocumentApprove::widget([
                'type' => DocumentApprove::TYPE_APPROVE,
                'model' => $model,
                'attribute' => 'listapprover',
                'users' => $listApprover,
                'approved' => $model->getUserHasApproved(),
                'currentLogin' => Yii::$app->user->id,
                'url' => ['approve'],
                'dataStatus' => [
                    'pending' => ApproverComfirm::STATUS_PENDING,
                    'rejected' => ApproverComfirm::STATUS_REJECTED,
                    'approved' => ApproverComfirm::STATUS_APPROVED,
                ],
                'options' => [
                    'class' => ''
                ]
            ]);

            ?>
        </div>
    </div>



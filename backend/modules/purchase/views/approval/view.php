<?php

/* @var $this yii\web\View */

use backend\modules\purchase\models\ApproverComfirm;
use backend\modules\purchase\widgets\documentapprove\DocumentApprove;
use yii\helpers\Html;
use backend\components\QueryString;

$this->title = \yii\helpers\BaseStringHelper::truncate($model->subject, 120);

?>
<style>
    #pr {
        padding: 10px;
        color: #000;
        border-radius: 7px;
    }
</style>

<div id="pr" class="row">
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Action</h3>
            </div>
            <div class="panel-body">

                <?php
                echo \yii\bootstrap\Nav::widget([
                        'encodeLabels' => false,
                    'options' => ['class' =>'nav-pills'],
                        'items' => [
                            [
                                'label' => '<i class="fa fa-edit"></i> Edit',
                                'url' => \backend\components\UrlNcode::to(['update', 'id' => $model->id]),
                               // 'visible' => Yii::$app->user->can('purchase/approval/update')
                            ],
                            [
                                'label' => '<i class="fa fa-ban"></i> Cancel',
                                'url' => \backend\components\UrlNcode::to(['cancel', 'id' => $model->id]),
                                'visible' => $model->canCancel(),
                            ],
                        ]
                ])
                ?>
            </div>
        </div>

        <?php
        $cancelDetail = $model->explodeCancelDetail();
        if (!empty($cancelDetail)) {
            ?>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">หมายเหตุยกเลิก</h3>
                </div>
                <div class="panel-body">
                    <?= \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $cancelDetail['cancelAt'],
                        'showTime' => true,
                    ]);
                    ?>
                    <p><?=Html::decode($cancelDetail['note'])?></p>
                </div>
            </div>
            <?php
        }
        ?>


    </div>
    <div class="col-md-6">
        <div class="row form-group">
            <div class="col-xs-2 col-sm-2"><?= Html::activeLabel($model, 'approve_status') ?></div>
            <div class="col-xs-10 col-sm-10 col-md-10">
                <?= $model->statusNameColor ?>
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

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Action</h3>
            </div>
            <div class="panel-body">
                <?php
                echo DocumentApprove::widget([
                    'type' => DocumentApprove::TYPE_APPROVE,
                    'model' => $model,
                    'attribute' => 'listapprover',
                    'users' => $listApprover,
                    'approved' => $listApproved,
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

    </div>
</div>



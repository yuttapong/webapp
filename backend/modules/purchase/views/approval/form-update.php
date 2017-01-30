<?php

/* @var $this yii\web\View */

use dosamigos\ckeditor\CKEditor;
use kartik\select2\Select2;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = \yii\helpers\BaseStringHelper::truncate($model->subject,120);


?>

    <style>
        #pr {
            background-color: #fff;
            padding: 10px;
            color: #000;
            border-radius: 7px;
        }
    </style>
<?php
$form = ActiveForm::begin([]);
?>


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



                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">สถานะ</h3>
                    </div>
                    <div class="panel-body">

                        <!-- ////////////// start status name  //// -->
                       <p><?=$model->statusNameColor?></p>
                        <!-- ////////////// end status name  //// -->



                        <!-- ////////////// start cancel note //// -->
                        <?php
                        $cancelDetail = $model->explodeCancelDetail();
                        if (!empty($cancelDetail)) {
                            $this->render('_note-cancel',['note'=>$cancelDetail]);
                        }
                        ?>
                        <!-- ////////////// end cancel note //// -->


                    </div>
                </div>



        </div>
        <div class="col-md-6">


            <?= $form->errorSummary($model) ?>

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
                    echo $form->field($model, 'job_list_id')->widget(Select2::className(), [
                        'data' => $jobGroupItem,
                        'options' => [
                            'placeholder' => 'Select a state ...',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ])->label(false);
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
                <div class="col-xs-12 col-sm-2 col-md-2"><?= Html::activeLabel($model, 'created_by') ?></div>

                <div class="col-xs-12 col-sm-10 col-md-10">
                    <?= $form->field($model, 'requestBy')->textInput(['readonly' => true])->label(false) ?>
                    <?= $form->field($model, 'created_by')->hiddenInput()->label(false) ?>
                </div>
            </div>


        </div>
        <div class="col-md-3">


            <?php
            echo \backend\modules\purchase\widgets\documentapprove\DocumentApprove::widget([
                'model' => $model,
               // 'type' => \backend\modules\purchase\widgets\documentapprove\DocumentApprove::TYPE_APPROVE,
                'attribute' => 'listapprover',
                'users' => $listApprover,
                'approved' => $model->getUserHasApproved(),
                'options' => [
                    'class' => ''
                ]
            ])
            ?>


            <p class="form-group">
            <div align="center">
                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            </p>


        </div>


    </div>

<?php ActiveForm::end(); ?>
<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use backend\modules\recruitment\RequestAsset;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmAppManpower $model
 * @var yii\widgets\ActiveForm $form
 */

?>

<div class="rc-app-manpower-form">

    <?php
    $form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'id' => 'manpower-form']);
    echo $form->errorSummary($model);
    echo FormGrid::widget([
        'model' => $model,
        'form' => $form,
        'autoGenerateColumns' => true,
        'columns' => 2,
        'rows' => [
            [
                'attributes' => [
                    'position_id' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options'=>[
                            'data'=>$model->positionList,
                            'pluginOptions' => [
                                'placeholder' => 'Select  ...',
                                'allowClear' => true
                            ],
                        ],
                        'hint'=>'ตำแหน่งงานที่ต้องการร้องขอ'
                    ],

                    'salary' => [
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'placeholder' => 'ไม่ต้องใส่คอมม่า...',
                            'maxlength' => 255,
                        ]
                    ],
                    'department_id' => ['type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => $model->getDepartmentList(),
                        'options' => ['prompt' => '-Select-']
                    ],


                ],
            ],
            [
                'attributes' => [
                    'leader_user_id' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => 'kartik\select2\Select2',
                        'options'=>[
                            'data'=> $model->getPersonnelList(),
                            'pluginOptions' => [
                                'placeholder' => 'Select  ...',
                                'allowClear' => true
                            ],
                        ],
                        'hint'=>'-หัวหน้างานของตำแหน่งนี้-'
                    ],

                    'date_to' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass'=>'\kartik\datecontrol\DateControl',
                    ],

                    'qty' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'จำนวนที่ต้องการรับ...']],



                ],
            ],

            [
                'attributes' => [
                    'company_id' => ['type' => Form::INPUT_DROPDOWN_LIST,
                        'items' => $model->companyList,
                        'options' => ['prompt' => '-Select-']
                    ],
                    'reason_request' => [
                        'type' => Form::INPUT_RADIO_LIST,
                        'options' => [
                            'placeholder' => 'Enter เหตุผลในการขอ...',
                            'class'=>'reason-request',
                           // 'onclick' => "checkReasonRequestType();",
                        ],
                         'items'  => $model->getReasonRequestTypeItems(),
                    ],

                    'reason_request_text' => [
                        'type' => Form::INPUT_TEXTAREA,
                        'options' => [
                            'placeholder' => 'เหตุผลในการขออื่น ๆ...', 'maxlength' => 255,'id'=>'reason-request-text']
                    ],

                ],
            ]
        ],
    ]);

    ?>


    <?php
    //หน้าความที่รับผิดชอบ
    echo $this->render('_items-responsibility', [
        'form' => $form,
        'model' => $model,
    ]);


    //คุณสมบัติผู้สมัคร
    echo $this->render('_items-property', [
        'form' => $form,
        'model' => $model,
    ]);

    //สวัสดิการ
    echo $this->render('_items-benefit', [
        'form' => $form,
        'model' => $model,
    ]);


    echo'<div class="form-group">';
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    echo Html::a(Yii::t('app', 'Cancel'),['index'],['class' => 'btn btn-default']);
    echo'</div>';
    ActiveForm::end(); ?>

</div>
<?php
RequestAsset::register($this);
?>



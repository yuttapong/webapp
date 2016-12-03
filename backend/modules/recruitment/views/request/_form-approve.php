<?php
use kartik\form\ActiveForm;
use kartik\popover\PopoverX;
use kartik\helpers\Html;

$currentUserId = Yii::$app->user->id;
$approverSeq= $model->approver_seq + 1;
if (isset($listApprove[$approverSeq]) && $listApprove[$approverSeq]['user_id'] == $currentUserId) {
    $form = ActiveForm::begin(['fieldConfig' => ['showLabels' => false]]);
    PopoverX::begin([
        'placement' => PopoverX::ALIGN_RIGHT_BOTTOM,
        'toggleButton' => ['label' => 'อนุมัติ', 'class' => 'btn btn-success'],
        'header' => '<i class="glyphicon glyphicon-lock"></i> อนุมัติเอกสาร',
        'footer' => Html::submitButton('บันทึก', ['class' => 'btn btn-sm btn-primary']) .
            Html::resetButton('Reset', ['class' => 'btn btn-sm btn-default'])
    ]);
    $user_code = 1;
    echo $form->field($modelApprove, 'app_status')->radioList($modelApprove->statusItems);
    echo $form->field($modelApprove, 'comment')->textArea(['rows' => '4']);
    echo $form->field($modelApprove, 'seq')->hiddenInput(['value' => $approverSeq]);
    echo $form->field($modelApprove, 'user_code')->hiddenInput(['value' => $listApprove[$approverSeq]['user_code']]);
    echo $form->field($modelApprove, 'position_name')->hiddenInput(['value' => $listApprove[$approverSeq]['position']]);

    echo $form->field($modelApprove, 'is_complete')->textInput(['value' => ($approverSeq == count($listApprove) ? 1 :0 )]);
    PopoverX::end();
    ActiveForm::end();
}
?>
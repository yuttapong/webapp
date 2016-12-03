<?php

use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Communication $model
 * @var yii\widgets\ActiveForm $form
 */
$datetime = $model->datetime ? explode(" ",date("Y-m-d H:i:s",$model->datetime)):[];
?>
<?php $form = ActiveForm::begin([
    'id' => 'communication-form',
   // 'enableAjaxValidation' => true,
]);
?>
<?= $form->field($model, 'date')->widget(\kartik\widgets\DatePicker::className(),[
    'language' => 'th',
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'autoclose' => true,
    ],
    'options' =>[
        'placeholder' => 'วันที่',
        'value' =>isset( $datetime[0])?$datetime[0]:date('Y-m-d'),
    ]
])?>
<?= $form->field($model, 'time')->widget(\kartik\widgets\TimePicker::className(),[
    'language' => 'th',
    'options' => [
        'value' =>isset( $datetime[1])?$datetime[1]:date('H:i:s'),
    ],
    'pluginOptions' => [
        'showSeconds' => true,
        'showMeridian' => false,
        'minuteStep' => 1,
        'secondStep' => 5,
    ],
])?>
<?= $form->field($model, 'detail')->textarea(['maxlength' => true]) ?>
<?php
echo Html::button($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), [
    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
   'onclick' => "$.ajax({
        url : $('#communication-form').attr('action'),
        type: 'post',
        data:$('#communication-form').serialize(),
        dataType:'json',
        success:function(rs){
        console.log(rs);
        if(rs.success == 1){
            $.pjax.reload({container:\"#grid-communication\"}); 
        }
        // $('.modal-customer .modal-body').html(rs);
        }
    });"
]);
ActiveForm::end(); ?>

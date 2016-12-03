<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Communication $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="communication-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]);

    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'type'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter ประเภท...', 'maxlength'=>60]],
            'title'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter หัวข้อ...', 'maxlength'=>120]],
            'detail'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter รายละเอียด...','rows'=> 6]],
        ]
    ]);
    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

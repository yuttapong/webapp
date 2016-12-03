<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmSetting $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="rcm-setting-form">

    <?php $form = ActiveForm::begin(['type'=>ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'name'=>['type'=> Form::INPUT_TEXT, 'options'=>['placeholder'=>'Enter Name...', 'maxlength'=>60]],

            'value'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Value...','rows'=> 6]],

            'description'=>['type'=> Form::INPUT_TEXTAREA, 'options'=>['placeholder'=>'Enter Description...','rows'=> 6]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
    ActiveForm::end(); ?>

</div>

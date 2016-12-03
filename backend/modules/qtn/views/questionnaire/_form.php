<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\qtn\models\Survey;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\models\Questionnaire */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="questionnaire-form">

    <?php $form = ActiveForm::begin(); ?>
<?php  
echo $form->field($model, 'survey_id')
    ->dropDownList(Survey::getSurvey(),
    	 [
                'id'=>'ddl-survey',
                'prompt'=>'เลือกเลือกแบบสำรวจ'
       ]  )->label('');
?>
    <?= $form->field($model, 'table_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

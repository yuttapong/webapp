<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\qtn\models\Survey;
use yii\helpers\ArrayHelper;
use backend\modules\qtn\models\QuestionType;
use backend\modules\qtn\models\SurveyTab;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\rest\OptionsAction;

/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\QtnQuestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qtn-question-form">

    <?php $form = ActiveForm::begin(); ?>

<?php 
echo $form->field($model, 'survey_id')
    ->dropDownList(Survey::getSurvey(),
    	 [
                'id'=>'ddl-survey',
                'prompt'=>'เลือกเลือกแบบสำรวจ'
       ]  )->label('');
?>
<?= $form->field($model, 'survey_tab_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-survey_tab'],
            'data'=> $survey_tab,
            'pluginOptions'=>[
                'depends'=>['ddl-survey'],
                'placeholder'=>'เลือก Tab...',
                'url'=>Url::to(['/qtn/question/surveytab'])
            ]
        ]); ?>
      <?= $form->field($model, 'survey_title_id')->widget(DepDrop::classname(), [
            'data' =>$survey_title,
            'pluginOptions'=>[
                'depends'=>['ddl-survey', 'ddl-survey_tab'],
                'placeholder'=>'เลือกตำบล...',
                'url'=>Url::to(['/qtn/question/get-survey-title'])
            ]
        ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


<?php 
echo $form->field($model, 'type_id')
    ->dropDownList(QuestionType::getQuestionType() ,
    		['prompt'=>'-Choose a Product-',
    		'onchange'=>'
  					 var url="http://chk_bk.dev:9090/qtn/question/type";
    				var data ={};	
    				data ={type:this.value};	
						$.ajax({
							url: url,
							type: "POST",
							data: data,
							success:function(data){
								$("#type_qtn").html(data);
							}
						});
            ']
    		 )->label('');
?>
<span id="type_qtn">fdd</span>
    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

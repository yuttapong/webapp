<?php
use kartik\form\ActiveForm;
use backend\modules\qtn\RequestAsset;
use yii\helpers\Html;
RequestAsset::register($this);
echo $modelTite->surveyTab->survey_id;
$form = ActiveForm::begin(['action' => ['survey/choice-title?id='.$id], 'id' => 'manpower-form' ,'enableAjaxValidation' => true,]);
echo Html::hiddenInput('survey_title_id',$modelTite->id);
echo Html::hiddenInput('survey_id',$modelTite->surveyTab->survey_id);
echo Html::hiddenInput('survey_tab_id',$modelTite->survey_tab_id);
//ตาราง choice
echo $this->render('_items-choice', [
		'form' => $form,
			'modelTite' =>$modelTite,
]);
//ตารางเพิ่มคำถาม
echo $this->render('_items-question', [
		'form' => $form,
			'modelTite' =>$modelTite,
]);
?>
 <div class="form-group">
        <?= Html::submitButton( 'บันทึก', ['class' =>  'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'),['index'],['class'=> 'btn btn-danger']) ?>
    </div>
<?php 
ActiveForm::end()
?>

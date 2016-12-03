<?php
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\modules\crm\models\ResponseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-search">

    <?php $form = ActiveForm::begin([
        'method' => 'post',
        'type' => \kartik\widgets\ActiveForm::TYPE_VERTICAL,

    ]); ?>


 <div class="row">
     <div class="col-xs-12 col-sm-6">
         <?= $form->field($model, 'site_id')->dropDownList($model->getSiteItems(), [
             'prompt' => '--ทั้งหมด--',
             'id' => 'site-id'
         ]); ?>
         <?php
         echo $form->field($model, 'survey_id')->widget(DepDrop::classname(), [
             'options' => ['id' => 'survey-id'],
             'pluginOptions' => [
                 'depends' => ['site-id'],
                 'placeholder' => 'Select...',
                 'url' => Url::to(['get-survey'])
             ]
         ]);
         ?>



     </div>
     <div class="col-xs-12 col-sm-6">
         <div class="well">
         <?= $form->field($model, 'dateStart')->widget(DateControl::classname(), [
             'type' => DateControl::FORMAT_DATE,
             'ajaxConversion' => false,
             'options' => [
                 'pluginOptions' => [
                     'autoclose' => true
                 ]
             ]
         ]) ?>

         <?= $form->field($model, 'dateEnd')->widget(DateControl::classname(), [
             'type' => DateControl::FORMAT_DATE,
             'ajaxConversion' => false,
             'options' => [
                 'pluginOptions' => [
                     'autoclose' => true
                 ]
             ]
         ]) ?>
         </div>
         <?= Html::submitButton('<i class="fa fa-table"></i> สงออกเป็นไฟล์ Exel', ['class' => 'btn btn-primary']) ?>
         <?= Html::resetButton('<i class="fa fa-refresh"></i> รีเซ็ท', ['class' => 'btn btn-default']) ?>
         
         </div>
 </div>

    <?php ActiveForm::end(); ?>

</div>
<hr>

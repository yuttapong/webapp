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

<div class="response-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'type' => \kartik\widgets\ActiveForm::TYPE_VERTICAL,

    ]); ?>
    <?= $form->field($model, 'site_id')->dropDownList($model->getSiteItems(), [
        'prompt' => '--เลือกโครงการ--',
        'id' => 'site-id'
    ]); ?>

    <?php  $form->field($model, 'survey_id')->dropDownList(\backend\modules\crm\models\Survey::getSurveyItems(), [
        'prompt' => '--ทั้งหมด--',
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


    <?= $form->field($model, 'duration')->dropDownList([
        'all' => 'ทั้งหมด',
        'today' => 'วันนี้',
        'month' => 'เดือนนี้',
        'year' => 'ปีนี้',
        'specify' => 'ระบุช่วงเวลา... ด้านล่าง',
    ],['prompt' => '--เลือกช่วงเวลา--']) ?>


    <div class="row">
        <div class="col-xs-12 col-sm-6"><?= $form->field($model, 'dateStart')->widget(DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]) ?></div>
        <div class="col-xs-12 col-sm-6"><?= $form->field($model, 'dateEnd')->widget(DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'options' => [
                    'pluginOptions' => [
                        'autoclose' => true
                    ]
                ]
            ]) ?></div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('ค้นหา', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('รีเซ็ท', ['class' => 'btn btn-default']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

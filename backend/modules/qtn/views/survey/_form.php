<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\org\models\OrgSite;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\qtn\Models\SurveyTabSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Survey Tabs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
				    <?php  
				echo $form->field($modelsSurvey, 'site_id')
				    ->dropDownList(OrgSite::getArraySite(),
				    	 [
				                'id'=>'ddl-survey',
				                'prompt'=>'เลือกเลือกแบบสำรวจ'
				       ]  );
				?>
    </div>
 <div class="row">
        <div class="col-sm-6">
            <?= $form->field($modelsSurvey, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($modelsSurvey, 'title')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
        <?php

         
         
         DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-tab',
        'widgetItem' => '.house-item',
        'limit' => 5,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $modelsTab[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'description',
        ],
    ]); ?>
  <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Tab</th>
                <th style="width: 450px;">หัวข้อ</th>
                <th class="text-center" style="width: 90px;">
                    <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span>+</button> 
                </th>
            </tr>
        </thead>
        <tbody class="container-tab">
           <?php foreach ($modelsTab as $indexTab => $modelTab): ?>
            <tr class="house-item">
                <td class="vcenter">
                    <?php
                 
                        // necessary for update action.
                        if (! $modelTab->isNewRecord) {
                            echo Html::activeHiddenInput($modelTab, "[{$indexTab}]id");
                        }
                    ?>
                    <?= $form->field($modelTab, "[{$indexTab}]name")->label(false)->textInput(['maxlength' => true]) ?>
                </td>
                   
                <td>
                 <?= $this->render('title/_form-title', [
                        'form' => $form,
                        'indexHouse' => $indexTab,
                        'modelsRoom' => $modelsTitle[$indexTab],
                    ]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus">-</span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table>
      <?php DynamicFormWidget::end(); ?>
       <div class="form-group">
        <?= Html::submitButton($modelsSurvey->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
    </div>
       <?php ActiveForm::end(); ?>
</div>
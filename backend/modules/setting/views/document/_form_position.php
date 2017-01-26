<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\ActiveForm;
use unclead\widgets\MultipleInput;
use common\widgets\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\SysDocument */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sys Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="person-form">


    <div class="row">
        <div class="col-sm-6">
           
            <?php  //echo $model->name?>
        </div>
    
    </div>
 	<div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    
    
     <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.house-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-house',
        'deleteButton' => '.remove-house',
        'model' => $modelPos[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'description',
        ],
    ]); ?>
      <table class="table table-bordered table-striped">
        <thead>
            <tr> 
            	<th width="6%">ลำดับ</th>
                <th width="20%">ตำแหน่ง</th>
               
                 <th class="text-center" >รายการ</th>
                <th class="text-center" style="width: 90px;">
                    <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
                </th>
            </tr>
        </thead>
          <tbody class="container-items">
        <?php foreach ($modelPos as $indexPostion => $modelPostion): ?>
            <tr class="house-item">
               <td>
                <?= $form->field($modelPostion, "[{$indexPostion}]seq")->label(false)->textInput(['maxlength' => true]) ?>
              
               
                </td>
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $modelPostion->isNewRecord) {
                            echo Html::activeHiddenInput($modelPostion, "[{$indexPostion}]id");
                        }
                    ?>
                      <?php  
						    echo $form->field($modelPostion, "[{$indexPostion}]position_id")->widget(Select2::classname(), [
						    		'data' => $modelPostion->positionList,
						    		'options' => ['placeholder' => 'Select a state ...'],
						    		'pluginOptions' => [
						    			'allowClear' => true
						    		],
						    ])->label(false); 
						    ?>
						   
                  
                </td>
                
                <td>
                <?php 
                $xx = $modelPostion->documentPersonnels;
                ?>
               <?= $this->render('_form-personnel', [
                        'form' => $form,
                        'indexPostion' => $indexPostion,
                        'modelsPersonnel' => $modelPersonnel[$indexPostion],
                    ]) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
    </table> 
     <?php DynamicFormWidget::end(); ?>
     
     
     
     

</div>

<?php

use yii\helpers\Html;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\widgets\ActiveForm;
$form = ActiveForm::begin([
		'id' => 'dynamic-form',
		'options' => ['class' => 'form-horizontal'],
]);
DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 10,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsHouse[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'description'
    ],
]); ?>
<table class="table table-bordered table-striped margin-b-none">
    <thead>
        <tr>
            <th>รายการ</th>
              <th>คะแนน</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
     <tbody class="form-options-body">
     <?php foreach ($modelsHouse as $indexRoom => $modelRoom): ?>
        <tr class="room-item">
            <td class="vcenter">
                <?php 
                    if (! $modelRoom->isNewRecord) {
                        echo Html::activeHiddenInput($modelRoom, "[{$indexRoom}][{$indexRoom}]id");
                    }
                ?>
            <?= $form->field($modelRoom, "[{$indexRoom}]content")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
             <td class="vcenter"> 
                 <?= $form->field($modelRoom, "[{$indexRoom}]score")->label(false)->textInput(['maxlength' => true]) ?>
              </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
       </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
<?php ActiveForm::end() ?>
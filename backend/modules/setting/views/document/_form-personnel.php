<?php

use yii\helpers\Html;
use common\widgets\dynamicform\DynamicFormWidget;
use kartik\select2\Select2;

?>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_inner',
    'widgetBody' => '.container-rooms',
    'widgetItem' => '.room-item',
    'limit' => 4,
    'min' => 1,
    'insertButton' => '.add-room',
    'deleteButton' => '.remove-room',
    'model' => $modelsPersonnel[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'description'
    ],
]); ?>
<table class="table table-bordered" border="1">
    <thead>
        <tr>
            <th>ผู้อนุมัติ</th>
            <th>site</th>
            <th>สถานะ</th>
            <th class="text-center">
                <button type="button" class="add-room btn btn-success btn-xs"><span class="glyphicon glyphicon-plus"></span></button>
            </th>
        </tr>
    </thead>
    <tbody class="container-rooms">
    <?php foreach ($modelsPersonnel as $indexRoom => $modelRoom): ?>
        <tr class="room-item">
            <td class="vcenter">
                <?php
                    // necessary for update action.
                    if (! $modelRoom->isNewRecord) {
                        echo Html::activeHiddenInput($modelRoom, "[{$indexPostion}][{$indexRoom}]id");
                    }
                    echo Html::activeHiddenInput($modelRoom, "[{$indexPostion}][{$indexRoom}]document_id");
                ?>
               
                  <?php  
						    echo $form->field($modelRoom, "[{$indexPostion}][{$indexRoom}]personnel_id")->widget(Select2::classname(), [
						    		'data' => $modelRoom->personnelList,
						    		'options' => ['placeholder' => 'Select a state ...'],
						    		'pluginOptions' => [
						    			'allowClear' => true
						    		],
						    ])->label(false); 
						    ?>
          
          
            </td>
            <td class="vcenter">
             <?= $form->field($modelRoom, "[{$indexPostion}][{$indexRoom}]site_id")->label(false)->textInput(['maxlength' => true]) ?>
             </td>
            <td class="vcenter">
             <?= $form->field($modelRoom, "[{$indexPostion}][{$indexRoom}]type")->label(false)->textInput(['maxlength' => true]) ?>
            </td>
            <td class="text-center vcenter" style="width: 90px;">
                <button type="button" class="remove-room btn btn-danger btn-xs"><span class="glyphicon glyphicon-minus"></span></button>
            </td>
        </tr>
     <?php endforeach; ?>
    </tbody>
</table>
<?php DynamicFormWidget::end(); ?>
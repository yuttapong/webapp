<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 24/9/2559
 * Time: 13:57
 */

use kartik\form\ActiveForm;
use yii\helpers\Html;



$this->title =  'แก้ไขแบบสอบถาม';

$this->params['breadcrumbs'][] = ['label' => 'ประเภทแบบสอบถาม', 'url' => ['survey/index']];
$this->params['breadcrumbs'][] = ['label' => $topic->survey->name, 'url' => ['survey/update','id'=>$topic->survey_id]];
$this->params['breadcrumbs'][] = $this->title ;

$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'id' => 'form-survey',
    'options' => [
    ],
]);
?>
<div align="right">
    <div class="btn-group">
        <?php
        echo Html::submitButton('<i class="fa fa-save"></i> บันทึก', ['class' => 'btn btn-primary']);
        echo Html::a('<i class="fa fa-arrow-left"></i> Back',['update','id'=>$topic->survey_id],['class'=>'btn btn-default']);
        ?>
    </div>
    </div>

    <div class="well well-sm">
        <?= $form->field($topic, 'name')->textInput(['class' => 'form-control'])->label("ID:".$topic->id) ?>
    </div>
<?php
foreach ($topic->questionChoices as $choiceIndex => $choice) {
    $inputSeq = $form->field($choice,"[{$choiceIndex}]seq")->textInput(['class'=>'form-control'])->label(false);
    $inputName = $form->field($choice,"[{$choiceIndex}]content")->textInput(['class'=>'form-control'])->label(false);
    $inputType = $form->field($choice,"[{$choiceIndex}]type")->dropDownList([
            'choice' => 'Choice',
            'another' => 'Other',
            'other_text' => 'อื่น ๆ รับค่าตัวหนังสือ',
            'other_number' => 'อื่น ๆ รับค่าตัวเลข',
        ]
    )->label(false);
    $optionAnswer = Html::activeDropDownList($choice, "[{$choiceIndex}]content", ['choice' => 'Choice', 'other' => 'Other'], [
        'class' => 'form-control',
        'prompt' => '--ประเภท--',
    ]);
/*    $choices[] = [
        'content' => "<div class='row'>
       <div class='col-md-1'>{$seq}</div>
       <div class='col-md-5 col-md-offset-1'>{$input}</div>
       <div class='col-md-4'>{$option}</div>
       </div>"
    ];*/

    echo "<div class='row'>
       <div class='col-md-1'>{$inputSeq}</div>
       <div class='col-md-7'>{$inputName}</div>
       <div class='col-md-4'>{$inputType}</div>
       </div>";
}

/*$choicesSort = \kartik\sortable\Sortable::widget([
    'items' => $choices,
    //'showHandle'=>true,
]);*/


?>


<?php
ActiveForm::end();
?>
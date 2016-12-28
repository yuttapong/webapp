<?php

/**
 * Created by PhpStorm.
 * User: RB
 * Date: 24/9/2559
 * Time: 13:57
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

use yii\jui\Sortable;

$this->title = 'แก่ไขคำตอบ';
$this->params['breadcrumbs'][] = ['label' => 'ประเภทแบบสอบถาม', 'url' => ['survey/index']];
$this->params['breadcrumbs'][] = ['label' => $topic->survey->name, 'url' => ['survey/update', 'id' => $topic->survey_id]];
$this->params['breadcrumbs'][] = $this->title;


$form = ActiveForm::begin([
    'id' => 'form-survey',
    'options' => [
    ],
]);
?>
    <div align="right">
        <div class="btn-group">
            <?php
            echo Html::a('<i class="fa fa-arrow-left"></i> Back', ['update', 'id' => $topic->survey_id], ['class' => 'btn btn-default']);
            echo Html::submitButton('<i class="fa fa-save"></i> บันทึก', ['class' => 'btn btn-primary btn-save-choice']);
            
            ?>
        </div>
    </div>


<p>

    <?= $form->field($topic, 'name')->textInput(['class' => 'form-control'])->label("ID:" . $topic->id) ?>
</p>

<?php
foreach ($topic->questionChoices as $choiceIndex => $choice) {
    $inputSeq = $form->field($choice, "[{$choiceIndex}]seq")->textInput(['class' => 'form-control cseq','readonly'=>true])->label(false);
    $inputName = $form->field($choice, "[{$choiceIndex}]content")->textInput(['class' => 'form-control'])->label(false);
    $inputType = $form->field($choice, "[{$choiceIndex}]type")->dropDownList([
            'choice' => 'Choice',
            'another' => 'Other',
            'other_text' => 'อื่น ๆ รับค่าตัวหนังสือ',
            'other_number' => 'อื่น ๆ รับค่าตัวเลข',
        ]
    )->label(false);
    $countAnswer = $choice->countAnswer;
    $inputActive = $form->field($choice, "[{$choiceIndex}]active")->checkbox();
    $optionAnswer = Html::activeDropDownList($choice, "[{$choiceIndex}]content", ['choice' => 'Choice', 'other' => 'Other'], [
        'class' => 'form-control',
        'prompt' => '--ประเภท--',
    ]);
    $colorForInactive = $choice->active===1?null:'text-danger';
    $content = "<div class='row {$colorForInactive}' data-choiceId='{$choice->id}' id='{$choice->id}'>
       <div class='col-xs-1 col-sm-1 col-md-1'>{$inputSeq}</div>
       <div class='col-xs-6 col-sm-6 col-md-6'>{$inputName}</div>
       <div class='col-xs-2 col-sm-2 col-md-2'>{$inputType}</div>
       <div class='col-xs-2 col-sm-2 col-md-2'>".($countAnswer>0?'<span class="badge">'.$countAnswer.'</span> Answer':'Empty Answer')."</span></div>
       <div class='col-xs-1 col-sm-1 col-md-1'>{$inputActive}</div>
       </div>";

    $items[] = [
        'content' => $content,
        'options' => [
            'id' => 'item-' .$choice->id,
        ]
    ];
}
echo Sortable::widget([
    'items' => $items,
    'options' => ['tag' => 'ul', 'class' => 'list-unstyled', 'id' => 'sortable-choice','data-qid'=>$topic->id],
    'itemOptions' => ['tag' => 'li'],
    'clientOptions' => ['cursor' => 'move'],
    'clientEvents' => [
        'stop' => 'function(e,item) { 
           $(".btn-save-choice").prop("disabled",true);
           var data = $(this).sortable(\'serialize\');
           var qid = $(this).data("qid");
           $.ajax({
             type:"post",
             url:"save-sort-choice?qid=" + qid,
             data: data,
             dataType:"json",
             success:function(rs){
              console.log(rs);
              if(rs.result === 1){
                    $(".cseq").each(function(index,item){
                        $(item).val(index+1);
                    });
                     $(".btn-save-choice").prop("disabled",false);
                 }
              }
           });
         }',
    ]
]);

ActiveForm::end();
?>

<?php

/**
 * Created by PhpStorm.
 * User: RB
 * Date: 20/8/2559
 * Time: 10:30
 */

use kartik\form\ActiveForm;
use kartik\helpers\Html;
use backend\modules\crm\SurveyAsset;
use yii\widgets\Pjax;
use yii\jui\JuiAsset;


JuiAsset::register($this);
SurveyAsset::register($this);
?>
<?php Pjax::begin() ?>

<div class="col-xs-12 col-xm-6 col-md-6">
    <?php
    \yii\grid\GridView::widget([
        'dataProvider' => $searchQ,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'name',
            'seq',
            [
                'class' => yii\grid\ActionColumn::className(),
                'template' => '{edit-topic}',
                'buttons' => [
                    'edit-topic' => function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>', $url, ['class' => 'view', 'data-pjax' => '0']);
                    },
                ],

            ],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]);
    ?>
</div>
<div class="col-xs-12 col-xm-6 col-md-6">
</div>

<?php Pjax::end() ?>
<hr>

<?php


$form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'id' => 'form-survey',
    'options' => [
    ],
]);

foreach ($model->questions as $questionIndex => $question) {

    $no = $questionIndex + 1 . ') ';
    $seq = $form->field($question, "[{$questionIndex}]seq")->textInput(['class' => 'form-control qseq', 'readonly' => true])->label(false);
    $topic = $form->field($question, "[{$questionIndex}]name")->textInput(['class' => 'form-control'])->label(false);
    $inputPublic = $form->field($question, "[{$questionIndex}]public")->dropDownList(['N'=>'Inactive', 'Y'=>'Active'])->label(false);
    //$inputPublic = $form->field($question, "[{$questionIndex}]public")->checkbox();
    $countChoice = count($question->questionChoices);
    $linkEditChoice = Html::a('<i class="fa fa-edit"></i> Choice '.($countChoice>0?'('.$countChoice.')':''), 
    ['survey/edit-topic', 'id' => $question->id],
    ['class' => 'btn btn-link']
    );
   

    /*************************
     * * Choice
     * ***********************/
    $choices = [];
    $choices = '';
    /*
    $buttonAddChoice = '<div align="right"><button type="button" data-q="' . $question->id . '" class="btn btn-xs btn-success">';
    $buttonAddChoice .= '<i class="fa fa-plus"></i>  เพิ่ม Choice</button></div>';
    $questionChoices = $question->questionChoices;
    foreach ($questionChoices as $choiceIndex => $choice) {

        $choices[] = [
            'content' => Html::activeInput("text", $choice, "[{$questionIndex}][{$choiceIndex}]content", ['value' => $choice->content, 'class' => 'form-control'])
        ];
    }

    $choicesSort = \yii\jui\Sortable::widget([
        'items' => $choices,
    ]);
    */

    $items[] = [
        // 'content' => "{$topic} <div id=\"containter-choice-{$question->id}\">{$choicesSort}</div><br>{$buttonAddChoice}",
        'content' => '<div class="row"><div class="col-sm-1">' . $seq . '</div> '
            . '<div class="col-sm-2">' . $question->type->type . '</div>'
            . '<div class="col-sm-6">' . $topic . '</div>'
            . '<div class="col-sm-1">' . $inputPublic . '</div>'
            . '<div class="col-sm-1">' . $linkEditChoice  . '</div>'
            . '</div>',
        'options' => [
            'id' => 'item-' . $question->id,
        ]
    ];
}

echo \yii\jui\Sortable::widget([
    'items' => $items,
    'options' => [
        'class' => 'list-unstyled',
        'data-survey-id' => $model->id,
    ],
    'itemOptions' => ['class' => ''],
    'clientEvents' => [
        'update' => 'function(e,item) { 
          $(".btn-save-survey").prop("disabled",true);
           var data = $(this).sortable(\'serialize\');
           var surveyId = $(this).data("survey-id");
           $.ajax({
             type:"post",
             url:"save-sort-question?survey_id=" + surveyId,
             dataType:"json",
             data: data,
             success:function(rs){
                 if(rs.result === 1){
                    $(".qseq").each(function(index,item){
                        $(item).val(index+1);
                    });
                     $(".btn-save-survey").prop("disabled",false);
                 }
              }
           });
         }',
    ]
]);
?>


    <?php

echo Html::submitButton('submit', ['class' => 'btn btn-primary btn-save-survey']);
ActiveForm::end();

?>



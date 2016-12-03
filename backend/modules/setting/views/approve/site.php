<?php
/* @var $this yii\web\View */


$this->title = 'การอนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use kartik\widgets\SwitchInput;
use common\models\SysDocumentOption;
use common\models\SysDocument;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\MultipleInputColumn;
?>

<?php $form = ActiveForm::begin([
]); ?>

<?php
foreach ($modelsDocument as $index => $doc) {
    ?>
    <div class="panel panel-info">
        <div class="panel-heading"><strong class="panel-title"><?= $doc->name ?></strong></div>
        <div class="panel-body">
            <!--  /////////////  //////////////-->
            <?php
            foreach ($doc->documentOptions as $index => $option) {

                //echo'<pre>';
                //print_r($option->extractData);
                //echo'</pre>';


                /**************************************
                 * อนุมัติตามที่กำหนดไว้
                 *************************************/
                if ($option->_type == SysDocumentOption::TYPE_CUSTOM) {
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-body">';
                    echo '<div class=" row">';
                    echo '<div class="col-xs-6 col-sm-6">';
                    echo $form->field($option, '_type')->widget(\kartik\widgets\Select2::className(), [
                        'data' => $option->typeItems,
                        'id' => uniqid()
                    ]);
                    echo '</div>';
                    echo '<div class="col-xs-12 col-sm-6 col-md-6">';
                    echo $form->field($option, 'active')->widget(SwitchInput::className(), [
                        'id' => uniqid()
                    ]);
                    echo '</div>';
                    $indexData = 0;
                    //foreach ($option->extractData as $data) {
                    echo '<div class="col-xs-6 col-sm-6 col-md-12">';
                        echo $form->field($option, 'users')->widget(MultipleInput::className(), [
                            'min' => 1,//อย่างน้อยมี 1 รายการ
                            'columns' => [
                                [
                                    'name' => 'user_code',
                                    'title' => 'พนักงาน',
                                   // 'defaultValue' => 1,
                                    'items' => $option->personnelItems,
                                    'options' => [
                                        'placeholder' => 'รหัสพนักงาน เช่น 56006',
                                    ]
                                ],
                                [
                                    'name' => 'position',
                                  //  'type' => \kartik\select2\Select2::className(),
                                    'type' => MultipleInputColumn::TYPE_DROPDOWN,
                                    'title' => 'ตำแหน่งงาน',
                                    'defaultValue' => '',
                                    'items' => $option->positionItems,
                                ],
                            ],
                        ])
                            ->label(false);
                    echo '</div>';
                        /*
                        echo '<div class="col-xs-6">';
                        echo $form->field($option, "[{$indexData}]user_code")
                            ->widget(\kartik\widgets\Select2::className(), [
                                'data' => $option->personnelItems,
                                'options' => [
                                    'id' => uniqid(),
                                    'value' => $data['user_code'],
                                ]
                            ]);

                        echo '</div>';
                        echo '<div class="col-xs-6">';

                        echo $form->field($option, "[{$indexData}]position")
                            ->widget(\kartik\widgets\Select2::className(), [
                                'data' => $option->positionItems,
                                'options' => [
                                    'id' => uniqid(),
                                    'value' => $data['position'],
                                ]
                            ]);
                        echo '</div>';
                        $indexData++;
                        */

                  //  }
                    echo '</div>';//row
                    echo '</div>';//well
                    echo '</div>';


                }


                /**************************************
                 * อนุมัติตามตำแหน่ง
                 *************************************/
                if ($option->_type == SysDocumentOption::TYPE_POSITION) {
                    echo '<div class="well">';
                    echo '<div class="row">';
                    echo '<div class="col-xs-6 col-sm-6">';
                    echo $form->field($option, "[{$index}]_type")->widget(\kartik\widgets\Select2::className(), [
                        'data' => $option->typeItems,
                        'id' => uniqid(),
                    ]);
                    echo '</div>';
                    echo '<div class="col-xs-12 col-sm-6">';
                    echo $form->field($option, "[{$index}]active")->widget(SwitchInput::className(), [
                        'id' => uniqid(),
                    ]);
                    echo '</div>';

                    echo '<div class="col-xs-12">';
                    echo \kartik\widgets\Select2::widget([
                        'name' => "[" . SysDocumentOption::TYPE_POSITION . "]",
                        'data' => $option->personnelItems,
                        'options' => [
                            'id' => uniqid(),
                            'value' => $option->extractData,
                            'multiple' => true,
                        ]
                    ]);

                    echo '</div>';

                    echo '</div>';// row
                    echo '</div>';
                }


            }
            ?>

        </div>
    </div>

    <?php


}
?>


<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Submit'), ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\helpers\Url;
use yii\helpers\Html;


//if( ! $modelPersonnel->isNewRecord){
    echo Html::activeHiddenInput($modelPersonnel,'id');
//}
echo FormGrid::widget([
    'model' =>  $modelPersonnel,
    'form' => $form,
    'autoGenerateColumns' => true,
    'rows' => [
        [
            'attributes' => [
                'nickname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter notes...']],
                /*
                'work_status' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $modelPersonnel->workStatusItems
                ],

                'work_type' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' =>$modelPersonnel->workTypeItems,
                    'options' => ['prompt' => '-Select-']
                ],
                */

                'birthday' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\datecontrol\DateControl::className(),
                    'options' => [

                    ]
                ],

            ]
        ],
        [
        //    'contentBefore' => '<legend class="text-info"><small>ข้อมูลชื่อ</small></legend>',
            'attributes' => [
                'prefix_name_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter username...']],
                'firstname_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter password...']],
                'lastname_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter password...']],


            ]
        ],
        [

            'attributes' => [       // 2 column layout
                'prefix_name_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter username...']],
                'firstname_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter password...']],
                'lastname_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter password...']],
            ]
        ],
        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลสถานะภาพ</small></legend>',
            'attributes' => [       // 2 column layout '
                'day_probation' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'กรอกเป็นตัวเลข...']],
                'military_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $modelPersonnel->militaryStatusItems,
                ],
                'living_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $modelPersonnel->livingStatusItems,
                ],
                'marriage_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' =>  $modelPersonnel->marriageStatusItems,
                ],

            ],
        ],

        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลสัญชาติและศาสนา</small></legend>',
            'attributes' => [       // 2 column layout '
                'nationality' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => [],
                    'items' =>  $modelPersonnel->nationalityItems,
                ],
                'race' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => ['placeholder' => 'Enter username...'],
                    'items' => $modelPersonnel->raceItems,
                ],
                'religion' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt'=>'-Select-'],
                    'items' => $modelPersonnel->religionItems,
                ],
                'blood' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => ['inline' => false],
                    'items' => $modelPersonnel->bloodItems,
                ],
            ]
        ],
        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลบัตรประประจำตัวประชาชน</small></legend>',
            'attributes' => [
                /*
                'idcard_province_id' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'options' => [
                        'data' => \common\models\SysProvince::getArrayProvince(),
                        'pluginOptions' => [
                            'allowClear' => true,
                            'placeholder' => '-Select-',
                            'options' =>[ 'id' => 'province-id',]
                        ],

                    ],
                    'hint' => 'จังหวัดทีออกบัตร',
                ],
            */
                'idcard_province_id' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'widgetClass' => \kartik\select2\Select2::className(),
                    'options' => [
                        'id' => 'province-id',
                        'prompt' => '----',
                    ],
                    'hint' => 'จังหวัดทีออกบัตร',
                    'items' => \common\models\SysProvince::getArrayProvince(),
                ],

                'idcard_amphur_id' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\depdrop\DepDrop::className(),
                    'options' => [
                        'data' => $citizenAmphur,
                        'id' => 'amphur-id',
                        'pluginOptions' => [
                            'depends' => ['province-id'],
                            'placeholder' => 'Select...',
                            'url' => Url::to(['get-amphur']),
                        ],
                    ],

                    'hint' => 'อำเภทที่ออกบัตร',


                ],

                'idcard_date_expiry' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\datecontrol\DateControl::className(),
                    'options' => []
                ],
                /*
                'actions'=>[    // embed raw HTML content
                    'type'=>Form::INPUT_RAW,
                    'value'=>  '<div style="text-align: right; margin-top: 20px">' .
                        Html::resetButton('Reset', ['class'=>'btn btn-default']) . ' ' .
                        Html::submitButton('Submit', ['class'=>'btn btn-primary']) .
                        '</div>'
                ],
                */
            ]
        ],
        /*
        [
            'attributes' => [
                'birthday' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\DatePicker', 'hint' => 'Enter birthday (mm/dd/yyyy)'],
                'state_1' => ['type' => Form::INPUT_DROPDOWN_LIST, 'items' => $model->typeahead_data, 'hint' => 'Type and select state'],
                'color' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => '\kartik\widgets\ColorInput', 'hint' => 'Choose your color'],
            ]
        ],
        [
            'attributes' => [       // 3 column layout
                'rememberMe' => [   // radio list
                    'type' => Form::INPUT_RADIO_LIST,
                    'items' => [true => 'Yes', false => 'No'],
                    'options' => ['inline' => true]
                ],
                'brightness' => [   // uses widget class with widget options
                    'type' => Form::INPUT_WIDGET,
                    'label' => Html::label('Brightness (%)'),
                    'widgetClass' => '\kartik\widgets\RangeInput',
                    'options' => ['width' => '80%']
                ],
                'actions' => [    // embed raw HTML content
                    'type' => Form::INPUT_RAW,
                    'value' => '<div style="text-align: right; margin-top: 20px">' .
                        Html::resetButton('Reset', ['class' => 'btn btn-default']) . ' ' .
                        Html::submitButton('Submit', ['class' => 'btn btn-primary']) .
                        '</div>'
                ],
            ],
        ],
        */
    ]
]);

?>
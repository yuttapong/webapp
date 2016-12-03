<?php
use kartik\builder\Form;
use kartik\builder\FormGrid;
use yii\helpers\Url;
use yii\helpers\Html;


if( ! $model->isNewRecord){
    echo Html::activeHiddenInput($model,'id');
}
echo FormGrid::widget([
    'model' =>  $model,
    'form' => $form,
    'autoGenerateColumns' => true,
    'rows' => [
        [
            'attributes' => [
                /*
                'file' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\file\FileInput::className(),
                    'options' => [
                        'options' => [
                            'accept' => 'image/*',
                            'multiple' => false
                        ],
                        'pluginOptions' => [
                            'previewFileType' => 'image',
                            // 'uploadUrl' => Url::to(['upload-photo-ajax']),
                            'showUpload' => false,
                            'showRemove' => true,
                            'showClose' => false,
                            'browseIcon' => '<i class="fa fa-image"></i> ',
                            // 'browseClass' => 'btn btn-primary btn-block',
                            'uploadExtraData' => [
                                'ref' => $model->id,
                            ],
                            'initialCaption' => "Photo",
                            'overwriteInitial' => true,
                            'initialPreviewShowDelete' => false,
                            'initialPreview' => $initialPreviewPhoto,
                            'initialPreviewConfig' => $initialPreviewPhotoConfig,
                            'maxFileSize' => 2000,
                            'autoReplace' => true,
                            'maxFileCount' => 1,
                        ]
                    ],

                ],
                */
                'birthday' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => \kartik\datecontrol\DateControl::className(),
                    'options' => []
                ],
                'nickname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ชื่อเล่น...']],
                /*
                'work_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $model->workStatusItems
                ],

                'work_type' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'items' =>$model->workTypeItems,
                     'options' => [
                         'prompt' => '--Select--'
                     ]
                ],
                 */

            ]
        ],
        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลชื่อ</small></legend>',
            'attributes' => [
                'prefix_name_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'คำนำหน้า...']],
                'firstname_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ชื่อ...']],
                'lastname_th' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'นามสกุล...']],


            ]
        ],
        [

            'attributes' => [       // 2 column layout
                'prefix_name_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Title...']],
                'firstname_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Firstname...']],
                'lastname_en' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Lastname...']],
            ]
        ],
        [
          'attributes' => [
              'birthday' => [
                  'type' => Form::INPUT_WIDGET,
                  'widgetClass' => \kartik\datecontrol\DateControl::className(),
                  'options' => []
              ],
              'nickname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ชื่อเล่น...']],
          ]
        ],
        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลสถานะภาพ</small></legend>',
            'attributes' => [       // 2 column layout '
                'day_probation' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'กรอกเป็นตัวเลข...']],
                'military_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $model->militaryStatusItems,
                ],
                'living_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' => $model->livingStatusItems,
                ],
                'marriage_status' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['prompt' => '-Select-'],
                    'items' =>  $model->marriageStatusItems,
                ],

            ],
        ],

        [
            'contentBefore' => '<legend class="text-info"><small>ข้อมูลสัญชาติและศาสนา</small></legend><div class="well">',
            'contentAfter' => '</div>',
            'attributes' => [       // 2 column layout '
                'nationality' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => [],
                    'items' =>  $model->nationalityItems,
                ],
                'race' => [
                    'type' => Form::INPUT_RADIO_LIST,
                    'options' => ['placeholder' => 'Enter เชื่อชาติ...'],
                    'items' => $model->raceItems,
                ],
                'religion' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => [],
                    'items' => $model->religionItems,
                ],
                'blood' => [
                    'type' => Form::INPUT_DROPDOWN_LIST,
                    'options' => ['inline' => false],
                    'items' => $model->bloodItems,
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
                        'prompt' => '-----',
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
<?phpuse yii\helpers\Html;use yii\helpers\Url;use kartik\builder\Form;use kartik\widgets\DepDrop;?><div class="box box-default box-solid">    <div class="box-header with-border">        <h3 class="box-title">ที่ทำงาน - Office</h3>        <div class="box-tools pull-right">            <!-- Buttons, labels, and many other things can be placed here! -->            <!-- Here is a label for example -->        </div><!-- /.box-tools -->    </div><!-- /.box-header -->    <div class="box-body"><?php$provinceId = 'ddl-province' . uniqid();$amphurId = 'ddl-amphur' . uniqid();$tambonId = 'ddl-tambon' . uniqid();echo \kartik\builder\FormGrid::widget([    'model' => $modelAddress,    'form' => $form,    //'autoGenerateColumns' => true,    'rows' => [        [            'attributes' => [                'company' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'บริษัท...']],                'province_id' => [                  'type' => Form::INPUT_DROPDOWN_LIST,                    'items' => $modelCustomer->provinceItems,                    'options' => [                         'id' => $provinceId,                        'prompt' => '-จังหวัด-',                    ]                ],                'amphur_id' => [                    'type' => FORM::INPUT_WIDGET,                    'widgetClass' => DepDrop::className(),                    'options' => [                        'id' => $amphurId,                        'pluginOptions' => [                            'depends' => [$provinceId],                            'placeholder' => 'เลือกอำเภอ...',                            'url' => Url::to(['get-amphur'])                        ]                    ]                ]            ],        ],    ]]);?><?phpecho $form->field($modelAddress, 'id')->hiddenInput(['id' => 'address-id', 'class' => '', 'readonly' => true])->label(false);?>    </div><!-- /.box-body -->    <div class="box-footer">    </div><!-- box-footer --></div><!-- /.box -->
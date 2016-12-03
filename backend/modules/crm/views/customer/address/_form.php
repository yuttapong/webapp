<?phpuse yii\helpers\Html;use yii\helpers\Url;use kartik\form\ActiveForm;use kartik\builder\Form;use kartik\widgets\DepDrop;?><?php$form = ActiveForm::begin([    'id' => 'form-address',    'options' => ['class' => 'edit_form'],    'enableAjaxValidation' => true,]);echo Form::widget([    'model' => $modelAddress,    'form' => $form,    'columns' => 4,    'attributes' => [        'type' => [            'type' => Form::INPUT_DROPDOWN_LIST,            'items' => $modelAddress->getTypeItems(),            'options' => [                'prompt' => '--ประเภท--',            ]        ],        'company' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ชื่อบริษัท...']],        'no' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'เลขที่...']],        'soi' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ซอย...']],        'moo' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'หมู่ที่...']],        'village' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'หมู่บ้าน...']],        'road' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ถนน...']],        /*        'active' => [                    'type'=>Form::INPUT_CHECKBOX,                    //'widgetClass'=> \kartik\widgets\SwitchInput::className(),                ]*/    ]]);?><div class="row">    <div class="col-xs-12 col-sm-4 col-md-4">        <?php        echo $form->field($modelAddress, "province_id")->dropDownList($modelCustomer->provinceItems, [            'id' => 'ddl-province',            'prompt' => '--เลือกจังหวัด--'        ]);        ?>    </div>    <div class="col-xs-12 col-sm-4 col-md-4">        <?php        echo $form->field($modelAddress, "amphur_id")->widget(DepDrop::classname(), [            'options' => ['id' => 'ddl-amphur'],            'data' => $modelAddress->amphurValue,            'pluginOptions' => [                'depends' => ['ddl-province'],                'placeholder' => 'เลือกอำเภอ...',                'url' => Url::to(['get-amphur'])            ]        ]);        ?>    </div>    <div class="col-xs-12 col-sm-4 col-md-4">        <?php        echo $form->field($modelAddress, "tambon_id")->widget(DepDrop::classname(), [            'options' => ['id' => 'ddl-tambon'],            'data' => $modelAddress->tambonValue,            'pluginOptions' => [                'depends' => ['ddl-province', 'ddl-amphur'],                'placeholder' => 'เลือกตำบล...',                'url' => Url::to(['get-tambon'])            ]        ]);        ?>    </div>    <div class="col-xs-12 col-sm-4 col-md-4">        <?php        echo $form->field($modelAddress, 'zipcode')->textInput(['class' => 'form-control']);        ?>    </div></div><p>    <?php    echo $form->field($modelAddress, 'id')->hiddenInput(['id' => 'address-id', 'class' => '', 'readonly' => true])->label(false);    echo Html::hiddenInput('customerId', (!$modelAddress->isNewRecord) ? $modelAddress->table_key : $customerId);    echo Html::submitButton($modelAddress->isNewRecord ? 'เพิ่ม' : 'แก้ไข', [        'class' => $modelAddress->isNewRecord ? 'btn btn-success' : ' btn btn-primary',        'id' => $modelAddress->isNewRecord ? 'save-address' : 'update-address',    ]);    ?></p><?phpActiveForm::end();$js = '/*$("#update-address").on("click",function () {    var id = $("#address-id").val();    var data = $("#form-address").serialize();    console.log("update");    $.ajax({        type:"post",        url: "update-address?id="+id,        data:data,        success:function(rs){        }    });});$("#save-address").on("click",function () {    var id = $("#address-id").val();    var data = $("#form-address").serialize();    console.log("save");    $.ajax({        type:"post",        url:"add-address",        data:data,        success:function(rs){           console.log(rs);                   }    });    */});';//$this->registerJs($js);?>
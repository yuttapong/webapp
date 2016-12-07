<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\home */
/* @var $form yii\widgets\ActiveForm */
?>

        <div class="row">
            <div class="col-xs-12">
                <div class="well">
                    <?= Typeahead::widget ([
                        'name'=> 'searchCustomer',
                        'options' => [
                            'placeholder' => 'ค้นหาลูกค้า:: ชื่อ, นามสกุล',
                            'id' => 'search-customer',
                        ],
                        'pluginOptions' => ['highlight' => true, 'minLength' => 2],
                        'pluginEvents' => [
                            "typeahead:selected" => "function(obj, item) { 
                                $('#home-customer_id').val(item.id);  
                                $('#customer-name').val(item.value);  
                                return true;
                             }",
                        ],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'name',
                                'remote' => [
                                    'url' => Url::to(['customer-list']) . '?q=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]
                        ]
                    ]) ?>
                </div>
            </div>
        </div>



    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?=Html::textInput('_firstname',null, ['class'=>'form-control','placeholder' => 'ชื่อ'])?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?=Html::textInput('_lastname',null, ['class'=>'form-control','placeholder' => 'นามสกุล'])?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?=Html::button('<i class="fa fa-plus"></i>',['ฺclass'=> 'btn btn-success']) ?>
        </div>
    </div>

    <div id="customer-result"></div>
    <p>
<div class="form-group">
    <?= Html::button('ตกลง', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>
    </p>

<?php
echo $this->registerJs('
  $("#search-customer").on("blur", function(e){
        console.log("ok");
        var name = $(this).val();
        if(name==""){
            $("#home-customers_id").val("");
        }
  });
');
?>

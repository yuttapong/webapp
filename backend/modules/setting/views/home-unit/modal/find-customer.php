<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\home */
/* @var $form yii\widgets\ActiveForm */
?>
<?php \yii\widgets\Pjax::begin();?>

        <div class="row">
            <div class="col-xs-12">
                <div class="well">
                    <?php echo Typeahead::widget ([
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

                <?php GridView::widget([
                    'dataProvider' => $dataProviderCustomer,
                    'filterModel' => $searchModelCustomer,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            // you may configure additional properties here
                        ],
                        'firstname',
                        'lastname',
                        /*
                        [
                            'attribute' => 'site_id',
                            'filter' => $searchModelCustomer->getSiteItems(),
                            'value' => 'site.site_name',
                        ],
                        [
                            'attribute' => 'company_id',
                            'filter' => $searchModelCustomer->getCompanyItems(),
                            'value' => 'company.name',
                        ],
                        */
                    ],
                ]); ?>

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
    <?= Html::button('ตกลง', ['class' => 'btn btn-primary btn-block']) ?>
</div>
    </p>
<?php \yii\widgets\Pjax::end();?>
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

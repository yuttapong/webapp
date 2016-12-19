<?php 
use backend\modules\purchase\models\Inventory;
use kartik\select2\Select2;
use yii\web\JsExpression;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form','action' =>['prin/chang-vendor'] ]); ?>
<div class="row"> 
<?php 


//$model->id=$id;
//$model->id=$id;
//$form->field($model, 'id')->hiddenInput()->label(false);


echo Html::hiddenInput('mainView', $view);
echo Html::hiddenInput('prin_detail_id', $id);
$cityDesc = empty($model->inventory_id) ? '' : Inventory::findOne($model->inventory_id)->name;

$url = Url::to(['prin/inventory-list','id'=>'']);
 echo $form->field($model, 'inventory_id')->widget(Select2::classname(),[
		'initValueText' => $cityDesc, // set the initial display text
		'name' => 'inventory_id',
		'value' => $model->inventory_id,
		'options' => ['placeholder' => 'Select a state ...','id'=>'inventory-id'.$id,  ],
		'pluginOptions' => [
				'allowClear' => true,
				'minimumInputLength' => 2,
				'language' => [
						'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
				],
				'ajax' => [
						'url' => $url,
						'dataType' => 'json',
						'data' => new JsExpression('function(params) { return {q:params.term}; }')
				],
				'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
				'templateResult' => new JsExpression('function(city) { return city.text; }'),
				'templateSelection' => new JsExpression('function (city) { return city.text; }'),
		],
]);
?>
</div>
<div class="row"> 
<?php 
echo $form->field($model, 'inventory_price_id')->widget(DepDrop::classname(), [
		'options'=>['id'=>'price-id'.$id],
		'data'=> $modelVendor,
		'pluginOptions'=>[
				'depends'=>['inventory-id'.$id],
				'placeholder'=>'Select...',
				 'url'=>Url::to(['/fix/prin/vender',['inventory_id'=>1]])
    ]
]);

?>
</div>
   <div class="form-group">
        <?= Html::submitButton(  'บันทึกข้อมูล', ['class' => 'btn btn-primary']) ?>
    </div>
  <?php ActiveForm::end(); ?>
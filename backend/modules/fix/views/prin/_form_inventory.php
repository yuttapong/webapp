<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
use yii\web\JsExpression;
$data = [
		"red" => "red",
		"green" => "green",
		"blue" => "blue",
		"orange" => "orange",
		"white" => "white",
		"black" => "black",
		"purple" => "purple",
		"cyan" => "cyan",
		"teal" => "teal"
];
?>

<li class="row"><p>
<div class="col-xs-5">
<input type="text" name="<?php echo $post['from'].'['.$post['row'];?>][name]" class="form-control" style="color:green;" value="<?=$post['name'];?>" >
</div>
<div class="col-xs-2">dd</div>
<div class="col-xs-2">
<?php 
$url = \yii\helpers\Url::to(['city-list']);
echo $form->field($model, 'id')->widget(Select2::classname(), [
    'initValueText' => '', // set the initial display text
    'options' => ['placeholder' => 'Search for a city ...'],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 3,
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
<div class="col-xs-2">dd</div>
<div class="col-xs-1">
<button type="button" class="remove-res btn btn-danger btn-xs" onclick="if(confirm('ต้องการลบรายการนี้ใชหรือไม่  ?')){$(this).parent().parent().remove();}">x</button>
</div>
</p></li>

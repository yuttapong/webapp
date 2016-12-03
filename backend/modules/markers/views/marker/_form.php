<?php
/**
 * Yii Google Maps markers
 *
 * @author Marc Oliveras Galvez <oligalma@gmail.com> 
 * @link http://www.ho96.com
 * @copyright 2016 Hosting 96
 * @license New BSD License
 */
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;
 
$this->registerCssFile(Yii::$app->controller->module->assetsUrl . '/css/markers.css', [], 'markerscss');
$this->registerCssFile(Yii::$app->controller->module->assetsUrl . '/css/form.css', [], 'markerscss2');
$this->registerJsFile(Yii::$app->controller->module->assetsUrl . '/js/tinymce/tinymce.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://maps.googleapis.com/maps/api/js?sensor=false', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs('
    tinymce.init({'
	. (file_exists(dirname(__FILE__) . '/../../assets/js/tinymce/langs/' . Yii::$app->language . '.js') ? ('language: "' . Yii::$app->language . '",') : '') .
	'selector: "#Marker_text",
	theme: "modern",
	plugins: [
	    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
	    "searchreplace wordcount visualblocks visualchars code fullscreen",
	    "insertdatetime media nonbreaking save table contextmenu directionality",
	    "emoticons template paste textcolor colorpicker textpattern"
	],
	toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image pastetext",
	toolbar2: "forecolor backcolor emoticons | fontselect | fontsizeselect | print preview code pagebreak media",
	image_advtab: true,
	templates: [
	    {title: "Test template 1", content: "Test 1"},
	    {title: "Test template 2", content: "Test 2"}
	],
	forced_root_block : "",
	content_css : "css/custom_content.css",
	theme_advanced_font_sizes: "10px,12px,13px,14px,16px,18px,20px",
	font_size_style_values : "10px,12px,13px,14px,16px,18px,20px",
    });
    
    $("#address").keydown(function(){
	var geocoder =  new google.maps.Geocoder();
	geocoder.geocode({ \'address\': $(\'#address\').val()}, function(results, status) {
	    $(\'#Marker_longitude\').val(results[0].geometry.location.lat());
	    $(\'#Marker_latitude\').val(results[0].geometry.location.lng());                
	});
    });
    
    $("#Marker_icon").change(function(){
	$("#icon-preview").attr("src","' . Yii::$app->controller->module->assetsUrl . '/images/icons/' . '" + $("#Marker_icon").val());
    });
    
    $(document).ready(function(){
	$("#icon-preview").attr("src","' . Yii::$app->controller->module->assetsUrl . '/images/icons/' . '" + $("#Marker_icon").val()); 
    });
',View::POS_END, 'markersjs');
?>	
<div class="form">
<?php $form = ActiveForm::begin(['id' => 'markers-form']);?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo Html::label('Type your address here', 'address'); ?>
        <?php echo Html::textInput('address', '', array('id' => 'address', 'class' => 'width-100pc')); ?>
    </div>
    
    <div class="row">
	<?php echo $form->field($model, 'longitude')->textInput(['id' => 'Marker_longitude', 'class'=>'width-200', 'autocomplete' => 'off']); ?>
    </div>
    
    <div class="row">
	<?php echo $form->field($model, 'latitude')->textInput(['id' => 'Marker_latitude', 'class'=>'width-200', 'autocomplete' => 'off']); ?>
    </div>

    <div class="row">
	<?php echo $form->field($model, 'icon')->listBox($icons, ['id' => 'Marker_icon', 'class'=>'width-200 height-200', 'autocomplete' => 'off', 'size' => 10]); ?>
        <img id="icon-preview" src="" />  
    </div>
    
    <div class="row">
	<?php echo $form->field($model, 'text')->textArea(['id' => 'Marker_text', 'class'=>'width-100pc', 'autocomplete' => 'off']); ?>
    </div>
    
    <div class="row buttons center padding-20-0">
	<?php echo Html::submitButton('Save'); ?>
    </div>
    
    <?= Html::hiddenInput('lang', Yii::$app->language) ?>
<?php ActiveForm::end(); ?>

</div><!-- form -->
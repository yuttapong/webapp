<?php
use yii\helpers\ArrayHelper;
use backend\modules\purchase\models\Vendor;
use yii\web\View;
use yii\bootstrap\Modal;


$seqVendor=Vendor::find()->all();
$dataVendor=ArrayHelper::map($seqVendor, 'id','company');
$script = <<< JS
   function loadInventery(url){
		$.ajax({
            		type     :'POST',
            		cache    : false,
            		url  : url,
            		success  : function(response) {
					
            		$('#modalContent').html(response);
					$('#modalx').modal('show')
            	
            }
        });
	
 }
JS;
$this->registerJs( $script,View::POS_HEAD);
?>
<div class="row">
	<?php echo $this->render('_search-pr-po', ['model' => $searchModel]); ?>
</div>
<div class="row">
	 	<?php echo $this->render('_form_poin', [
	 			'model' => $searchModel,
	 			'dataProvider' => $dataProvider,
	 			'modelPoin' =>$modelPoin
	 	]); ?>
 </div>           
 <?php          
   Modal::begin([
   		'header'=>'<h4 class="title">Job Created</h4>',
   		'options' => [
   				'id'=>'modalx',
   				'tabindex' => false,
   				'size'=>'modal-lg',
   		], 
   		//'toggleButton' => ['label' => 'Show Modal', 'class' => 'btn btn-lg btn-primary'],
   ]);

   echo "<div id='modalContent'></div>";
   Modal::end();
   ?>
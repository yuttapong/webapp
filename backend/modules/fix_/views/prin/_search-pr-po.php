<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="prin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['pr-to-po'],
        'method' => 'get',
    ]); ?>
<div class="row">
	<div class="col-sm-4">
		<?= $form->field($model, 'vendor_id') ?>
	</div>
	<div class="col-sm-8">
	  <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
   	 </div>
	</div>
</div>


  

    <?php ActiveForm::end(); ?>

</div>
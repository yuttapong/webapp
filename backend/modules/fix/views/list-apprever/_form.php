<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\fix\models\InformJob;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\ListApprever */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="list-apprever-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'list')->textInput() ?>

<?= $form->field($model, 'is_pr')->radioList(['0' => 'ไม่ต้องการเปิด pr', '1' => 'ต้องการเปิด pr'])->label(false) ?>
<div class="row">
     <?php   
if($model->isNewRecord){
  $region = InformJob::find()->where(['inform_fix_id'=> $inform_fix_id])
  ->andWhere([ 'job_status' => null]) ;
}else{
	$region = InformJob::find()->where(['inform_fix_id'=> $inform_fix_id]) ;
}
  echo maksyutin\duallistbox\Widget::widget([
  		'model' => $model,
  		'attribute' => 'job_selected',
  		'title' => 'ขออนุมัติ',
  		'data' => $region,
  		'data_id'=> 'id',
  		'data_value'=> 'list',
  		'lngOptions' => [
  				'warning_info' => 'Вы уверены, что хотите выбрать такое количество элементов?
                           Возможно Ваш браузер может перестанет отвечать на запросы..',
  				'search_placeholder' => 'ค้นหา',
  				'showing' => ' -',
  				'available' => 'รายการที่จะเข้าไปทำ',
  				'selected' => 'รายการที่ขออนุมัติ'
  		]
  ]);
?>
</div>

    <?php //= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

<?php 
echo '<strong>อนุมัติตามลำดับ</strong><br>';
if(count($listApprove)>0){
	foreach ($listApprove as $val){
		echo $val['fullname'].'<br>';
	}
	
}
?>


    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

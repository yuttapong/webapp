<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use softark\duallistbox\DualListbox;
use backend\modules\fix\models\InformJob;

//echo '<pre>';
//print_r($listApprove);
//echo '</pre>';
if(count($listApprove)>0){
	$iAp=1;
	foreach ($listApprove as $val){
		echo $iAp.'. '.$val['fullname'].' <br>';
		$iAp++;
	}
	
}
 ?>กกกกกกกกก
  <?php   

  $region = InformJob::find()->where(['inform_fix_id'=> $inform_fix_id]);
  echo maksyutin\duallistbox\Widget::widget([
  		'model' => $model,
  		'attribute' => 'job_selected',
  		'title' => 'города',
  		'data' => $region,
  		'data_id'=> 'id',
  		'data_value'=> 'list',
  		'lngOptions' => [
  				'warning_info' => 'Вы уверены, что хотите выбрать такое количество элементов?
                           Возможно Ваш браузер может перестанет отвечать на запросы..',
  				'search_placeholder' => 'Фильтр',
  				'showing' => ' -',
  				'available' => 'รายการที่จะเข้าไปทำ',
  				'selected' => 'รายการที่ขออนุมัติ'
  		]
  ]);
?>


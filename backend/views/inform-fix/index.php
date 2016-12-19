<?php
use yii\helpers\Url;
use yii\helpers\Html;
use backend\modules\fix\models\SendDocuments;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use backend\modules\org\models\OrgPersonnel;
/* @var $this yii\web\View */






$user_id='';
if(!empty($dataKey['recipient_user_id'])){
	$user_id=$dataKey['recipient_user_id'];
}
?>
<div class="inform-fix-view">
<div class="row">
	<div class="col-md-4">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        'code',

            [
            'attribute' => 'project_id',
            'value'  => $model->project->name,
            ],
            [
            'attribute' => 'home_id',
            'value'  => 'แปลง '.$model->home->plan_no.' เลขที่ '. $model->home->home_no,
            ],
            [
            'attribute' => 'name_inform',
            'label'=>'ลูกค้า',
            'value'  => $model->prefixname.' '.$model->customer_name,
            ],
            [
            'attribute' => 'work_status',
            'value'  => $model->workStatus[$model->work_status],
            ],

        ],
    ]) ?>

	</div>
	<div class="col-md-8">
	<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
        	'date_inform:datetime',
        	[
        	'attribute' => 'home.date_insurance',
        	'value'  => $model->home->date_insurance!=''?date ( "d-m-Y", $model->home->date_insurance):'' ,
        	],
           // 'telephone',
            'description:ntext',
        ],
    ]) ?>
	</div>

</div>
</div>

<?php
if (count($model->informJobs)>0){
	$i=1;
	echo '<strong>รายละเอียดงานที่เข้าไปซ่อม</strong><br>';
	foreach ($model->informJobs as $val){
		echo $i.' '. $val->list.'<br>';
		$i++;
	}
}
?>

    <?php Pjax::begin(['id' => 'fdcountries']) ?>
       <?php

 $modelSen= SendDocuments::findOne(
 		['table_name' => 'fix_inform_fix','table_key'=>$model->id,'recipient_user_id'=>$user_id,'is_khow'=>'0' ]
 ) ;

 if(count($modelSen)>0 && $modelSen->is_khow==0){
 	$personnel=OrgPersonnel::findOne(['user_id'=>$user_id]);
 	echo $personnel->prefix_name_th.' '.$personnel->firstname_th.' '.$personnel->lastname_th.' ';
 $url_sen=Url::to(['inform-fix/send-acknowledge','id'=>$model->id,'user_id'=>$user_id]) ;
 echo  '    '.Html::a(Html::button('รับทราบ',[ 'class' => 'btn btn-info','id'=>'hho' ]), '', [
             			'title' => \Yii::t('yii', 'รับทราบ'),
             			'onclick'=>"
             			$.ajax({
 							cache    : false,
	             			type     :'POST', 
 							 data: { _csrf: yii.getCsrfToken()}, 
 		  				contentType: \"application/json; charset=utf-8\",
	             			url  : '$url_sen',
	             			success  : function(response) {
		             			$('#modal_fd .title').html('รับทราบ');
		             			$('#modal_fd').modal('show')
		             			$('#modal_fd .modal-body').html(response);
				             }
			             });return false;",
             			'data-pjax' => '0',
             	]);
 }
 ?>

  <?php Pjax::end() ?>

    <?php
   Modal::begin([
   		'header'=>'<h4 class="title">Job Created</h4>',
   		'id'=>'modal_fd',
   		'size'=>'modal-lg',
   ]);

   echo "<div id='modalContent'></div>";
   Modal::end();
   ?>
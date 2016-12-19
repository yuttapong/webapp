<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use common\widgets\modalAjax\ajaxModal;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use backend\modules\fix\models\SendDocuments;
use common\siricenter\thaiformatter\ThaiDate;
/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformFix */

$this->title = 'แปลง '.$model->home->plan_no.' เลขที่ '. $model->home->home_no;
$this->params['breadcrumbs'][] = ['label' => 'Inform Fixes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/fix/inform_fix.js');
?><?php Pjax::begin(['id' => 'countries']) ?>
<div class="inform-fix-view">
 <p> 
 <?php  
 if(Yii::$app->user->id==133){
 $url=Url::to(['list-apprever/create','inform_fix_id'=>$model->id]);
 echo Html::button('ขออนุมัติ', [ 'class' => 'btn btn-primary' 
 		, 'onclick' =>"
				 $.ajax({
					type     :'POST',
					 cache    : false,
					 url  : '$url',
					  success  : function(response) { 
 						$('.modal-header .title').html('ขออนุมัติ');
						$('#modal').modal('show')
						$('#modal .modal-body').html(response);
					 }
				  });return false;"
 ]); ?>
  <?php 
  $url=Url::to(['inform-fix/list-pr','inform_fix_id'=>$model->id]);
        echo Html::button('รายการที่ต้องเปิด pr', [ 'class' => 'btn btn-primary'
        		, 'onclick' =>"
        		$.ajax({
        		type     :'POST',
        		cache    : false,
        		url  : '$url',
        		success  : function(response) {
        		$('.modal-header .title').html('รายการที่ต้องเปิด pr');
        		$('#modal').modal('show')
        		$('#modal .modal-body').html(response);
        		}
        		});return false;"
         ]);
 
        ?>
        <?php 

 }
        ?>
        <?php 
        $url=Url::to(['inform-fix/customer-service','id'=>$model->id]);
        echo Html::button('กรอกข้อมูลลูกค้า', [ 'class' => 'btn btn-info'
        		, 'onclick' =>"
        		$.ajax({
        		type     :'POST',
        		cache    : false,
        		url  : '$url',
        		success  : function(response) {
        		$('.modal-header .title').html('กรอกข้อมูลลูกค้า');
        		$('#modal').modal('show')
        		$('#modal .modal-body').html(response);
        }
        });return false;"
        ]);
        ?>
      <?php echo \yii\helpers\Html::a(  Html::button('ย้อนกลับ',[ 'class' => 'btn btn-primary' ]), Yii::$app->request->referrer); ?>

  </p>
 
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
 
        	[
        	'attribute' => 'date_inform',
        	'value'  => 
        	 $model->date_inform!=''?ThaiDate::widget([
            			'timestamp' => $model->date_inform,
            			'type' => ThaiDate::TYPE_MEDIUM,
            			'showTime' => true
            	]) :'' ,
        	
        	],
        	[
        	'attribute' => 'home.date_insurance',
        	'value'  => $model->home->date_insurance!=''?date ( "d-m-Y", $model->home->date_insurance):'' ,
        	],
            'telephone',
            'description:ntext',
        ], 
    ]) ?>
	</div>
	
</div>   
</div>

<div class="row">
 <?php 
 if(Yii::$app->user->id==133){
$url=Url::to(['inform-job/create','inform_fix_id'=>$model->id]);
echo Html::button('เพิ่มงานที่ทำ', [ 'class' => 'btn btn-primary', 'onclick' =>"
				 $.ajax({
					type     :'POST',
					 cache    : false,
					 url  : '$url',
					  success  : function(response) { 
							$('.modal-header .title').html('เพิ่มงานที่ทำ');
							 	$('#modal').modal('show')
							    $('#modal .modal-body').html(response);
						  }
				  });return false;" ]);

 } 
  
    ?>

 

  <?php   
  echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
            'list',
        	'solution:ntext',
        	'problem:ntext',
            'description:ntext',
           
        	 'responsible_name',
        		[
        		'class' => 'yii\grid\ActionColumn',
        		
        		'buttons' => [
        				'edit' => function ($url, $model) { 
        				$url=Url::to(['/fix/inform-job/update','inform_fix_id'=>$model->inform_fix_id,'job_id'=>$model->id]) ;
        					  return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => \Yii::t('yii', 'Update'),
        					  		'onclick'=>"
											     $.ajax({
											    type     :'POST',
											    cache    : false,
											    url  : '$url',
											    success  : function(response) { 
        					  						  $('#modal').modal('show')
											          $('#modal .modal-body').html(response);
											    }
											    });return false;",
                                    			'data-pjax' => '0',
                        ]);
        				},
        				'view' => function ($url, $model) { 
        				$url=Url::to(['/fix/inform-job/view','id'=>$model->id]) ;
        					return Html::a('ดู', $url, [
                                    'title' => \Yii::t('yii', 'Update'),
        					  		'onclick'=>"
											     $.ajax({
											    type     :'POST',
											    cache    : false,
											    url  : '$url',
											    success  : function(response) { 
        					  						  $('#modal').modal('show')
											          $('#modal .modal-body').html(response);
											    }
											    });return false;",
                                    			'data-pjax' => '0',
                        ]);
        				}
        				
        				
        		],
        		'template' => '{edit} {view}',
        		'visibleButtons' => [
        				'edit' => function ($model, $key, $index) {
        					return $model->informFix->work_status == 3 ? false : true;
        				},
        		
        				]
        	],
        ],
    ]); ?>
 
</div>
<div class="row">

  
    <?php 
    if(Yii::$app->user->id==133){
  
if(count($model->informMaterial)>0){ 
	echo 'วัสดุที่ใช่ในงานนี้ <br>';
	$inv=1;
	foreach ($model->informMaterial as $mat){
		echo $inv.'. '.$mat->name.'<br>';
		$inv++;
	}
	
} 
    }
?>
</div>
<?php 
if(count($model->uploads)>0){
	foreach ($model->uploads as $vUpload){
		
	}
}

?>
<?php 
if(Yii::$app->user->id==133){
if(count($model->listApprever)>0){
	$ia=1;
	foreach ($model->listApprever as $vListA){

		$url=Url::to(['list-apprever/update','id'=>$vListA->id,'inform_fix_id'=>$vListA->inform_fix_id]);
		$buntton = Html::button('ขออนุมัติ', [ 'class' => 'btn btn-primary'
				, 'onclick' =>"
				$.ajax({
				type     :'POST',
				cache    : false,
				url  : '$url',
				success  : function(response) {
				$('.modal-header .title').html('ขออนุมัติ');
				$('#modal').modal('show')
				$('#modal .modal-body').html(response);
		}
		});return false;"
		]);
		
		echo $ia.'. '.$vListA->list.$buntton.'<br>';
		$ia++;
	}
}
}
?>


     <?php 
     $item=$model->getThumbnails($model->id,'d'); 
     if(!empty($item['img'])&& count($item['img'])>0){ ?>
     	<div class="panel panel-default">
  			<div class="panel-body">
    			<?php 
    			//if(Yii::$app->user->id==133){
    			echo dosamigos\gallery\Gallery::widget(['items' =>$item['img']]);
    			//}
    			
    			?>
    		</div>
		</div>
   <?php   } ?>
 
 <?php Pjax::end() ?>

    <?php 
if(!empty($item['other'])){
	foreach ($item['other'] as $val){
		//echo $val;
		
		echo Html::a($val['name'], ['inform-fix/download','id'=>$val['upload_id']]).'<br>';
	}

}?>
<br>
   <p>
        <?php
		if( $model->work_status !=3 && $model->is_delete==0 ){
        echo  Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?php } ?>
       <?php 
     
 $modelSen= SendDocuments::findOne(
 		['table_name' => 'fix_inform_fix','table_key'=>$model->id,'recipient_user_id'=>Yii::$app->user->id,'is_khow'=>'0' ]
 ) ;

 if(count($modelSen)>0 && $modelSen->is_khow==0){
 $url_sen=Url::to(['/fix/inform-fix/send-acknowledge','id'=>$model->id]) ;
 echo  '    '.Html::a(Html::button('รับทราบ',[ 'class' => 'btn btn-info' ]), '', [
             			'title' => \Yii::t('yii', 'รับทราบ'),
             			'onclick'=>"
             			$.ajax({
	             			type     :'POST',
	             			cache    : false,
	             			url  : '$url_sen',
	             			success  : function(response) {
		             			$('#modal .title').html('รับทราบ');
		             			$('#modal').modal('show')
		             			$('#modal .modal-body').html(response);
				             }
			             });return false;",
             			'data-pjax' => '0',
             	]);
 }
 
 ?>
    </p>

    <?php 
  if(count($model->sendDocumentsl)>0){
  	echo 'ประวัติการแจ้ง<br>';
  	$i=1;
  	foreach ($model->sendDocumentsl as $val){
  		$text='<span class="bg-danger" >ยังไม่่รับทราพ</span>';
  		if( $val->is_khow==1){
  			$text='<span class="bg-success" >รับทราพแล้ว</span>';
  		}
  		
  		echo $i.'. '. $val->recipient_user_name.'   '.$text.'  '.$val->title.'<br>';
  		$i++;
  	}
  	
  }

  
  ?>

   <?php
   Modal::begin([
   		'header'=>'<h4 class="title">Job Created</h4>',
   		'id'=>'modal',
   		'size'=>'modal-lg',
   ]);
   
   echo "<div id='modalContent'></div>";
   Modal::end();
   ?>

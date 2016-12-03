<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\BaseStringHelper;
use kartik\datecontrol\DateControl;
use common\siricenter\thaiformatter\ThaiDate;
use common\models\Calendar;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\InformFixSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'แจ้งซ่อมบ้าน';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="inform-fix-index5">
   <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่มข้อมูล', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php \yii\widgets\Pjax::begin(['id' => 'p-inform-fixes']); ?>
     
    <?= GridView::widget([
   		 'id' => 'grid-inform-fixes',
        'dataProvider' => $dataProvider,
      // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            
            [
	            'attribute' =>   'project_id',
	            'format' => 'raw',
	            'value' => function ($model) {
	            	return  $model->project->name;
	            
	            },
            ],
            'home.plan_no',
            'home.home_no',
            [
            'attribute' => 'home.date_insurance',
            'format' => 'raw',
            'value'=> function($data) {
            	$text=  $data->home->date_insurance!=''?ThaiDate::widget([
            			'timestamp' => $data->home->date_insurance,
            			'type' => ThaiDate::TYPE_SHORT,
            			'showTime' => false
            	]) :'' ;
            	//if($data->home->date_insurance=='' || Yii::$app->user->id=='133'){
            	$date_insurance='<i class="fa fa-calendar"></i>เพิ่มวันที่';
            
            	if($data->home->date_insurance!='' && $data->home->date_insurance !='0'){
            		 
            		$date_insurance= date( "m-Y ", $data->home->date_insurance )  ;
            		$date_insurance=  ThaiDate::widget([
            				'timestamp' =>$data->home->date_insurance,
            				 'type' => ThaiDate::TYPE_MEDIUM,
            				'showTime' => false   ]);
            	}
            
            	$url=Url::to(['/fix/inform-fix/send-date-insurance','id'=>$data->home_id]) ;
            	$text= Html::a($date_insurance, $url, [
            			'title' => \Yii::t('yii', 'ส่งงาน'),
            			'onclick'=>"
            			$.ajax({
            			type     :'POST',
            			cache    : false,
            			url  : '$url',
            			success  : function(response) {
            			$('#modal .title').html('วันที่ประกันบ้าน');
            			$('#modal').modal('show')
            			$('#modal .modal-body').html(response);
            
            }
            });return false;",
            			'data-pjax' => '0',
            	]);
            			//}
            			return $text;
            			 
            },
            	],
      
            [
            'attribute' =>   'customer_name',
            'format' => 'raw',
            'value' => function ($model) {
            	return $model->customer_name;
            },
            ],
            // 'title',
            // 'description:ntext',
            [
            'attribute' =>   'id',
          'label' => 'รายการแจ้ง',
            'format' => 'raw',
            'value' => function ($model) {
            $text='';
            if(count($model->informJobs)>0){
            	$i=1;
            	foreach ($model->informJobs as $val){
            		$text.=$i.' '.BaseStringHelper::truncate($val->list, 50).'<br>';
            		
            		
            		$i++;
            	}
            }
            	return $text;
            },
            ],
   
            [
            'attribute' =>   'date_inform',
            'format' => 'raw',
            'value' => function ($model) {
            	$date_inform='';
            	if($model->date_inform!=''){
            		$date_inform=  ThaiDate::widget([ 
            				'timestamp' => $model->date_inform, 'type' => 
            				ThaiDate::TYPE_MEDIUM,
            				 'showTime' => false   ]);
            	}
            	return $date_inform;
            },
            ],
            [
            'attribute' =>   'date_modify',
            'format' => 'raw',
            'value' => function ($model) {
            	$date_modify='';
	            if($model->date_modify!=''){
	         	 $date_modify=  ThaiDate::widget([ 'timestamp' => $model->date_modify, 'type' => ThaiDate::TYPE_MEDIUM,  'showTime' => false   ]);
	            }
	         	 return $date_modify;
            },
            ],
            [
            'class' => '\kartik\grid\EditableColumn',
           // 'header' => 'work_status', 
            'attribute' =>   'work_status',
            		'value' => function ($model) {
            		return $model->workStatusName;
            },
            'editableOptions' => function($oModel) {
            	return [
            		'inputType' => Editable::INPUT_DROPDOWN_LIST,
            		'name' => 'work_status',
            		'data' => $oModel->workStatus ,'value' => $oModel->workStatus[$oModel->work_status],
            	];
            },
            ],
   
            // 'job_status',
            // 'job_sub_status',
            // 'created_at',
            // 'created_by',
            // 'type',
             [
             'label'=>'ปฏิทิน',
             'format' => 'raw',
             'value'=>function ($data) {
             $text='เพิ่มลงในปฏิทิน';
             $icon='<i class="glyphicon glyphicon-send"></i>';
             $url=Url::to(['/fix/work-event/create','id'=>$data->id]) ;
             if($data->is_calendar!='0'){ 
             	$text='แก้ไขปฏิทิน';
             	
             	$modelSen= Calendar::findOne(
             			['table_name' => 'fix_inform_fix','table_key'=>$data->id ] ) ;
             	
             	if ($modelSen){
             		$url=Url::to(['/fix/work-event/update','id'=>$modelSen->id]) ;
             		$icon='<i class="glyphicon glyphicon-pencil"></i>';
             	}
             }	
             	return Html::a($icon, $url, [
             			'title' => \Yii::t('yii', 'ปฏิทิน'),
             			'onclick'=>"
             			$.ajax({
             			type     :'POST',
             			cache    : false,
             			url  : '$url',
             			success  : function(response) {
             			$('#modal .title').html('$text');
             			$('#modal').modal('show')
             			$('#modal .modal-body').html(response);
             			
             	}
             	});return false;",
             			'data-pjax' => '0',
             	]);
             },
             ],
             [
             'label'=>'word',
             'format' => 'raw',
             'value'=>function ($data) {
             $url=Url::to(['/fix/inform-fix/word','id'=>$data->id]) ;
             	return Html::a('<i class="glyphicon glyphicon-download-alt"></i>', $url, ['data-pjax' => '0']);
             },
             ],
             [
             
             'attribute' => 'is_send',
             		'label'=>'แจ้งเตือน',
             'format' => 'raw',
             'value'=> function($data) {
             	$text=  $data->is_send?'<span class="glyphicon glyphicon-ok text-success"></span>':'<span class="glyphicon glyphicon-remove text-danger"></span>';
             	$url=Url::to(['/fix/inform-fix/send-user','id'=>$data->id]) ;
             	return Html::a('<i class="fa fa-send"></i>', $url, [
             			'title' => \Yii::t('yii', 'ส่งงาน'),
             			'onclick'=>"
             			$.ajax({
             			type     :'POST',
             			cache    : false,
             			 data: { _csrf: yii.getCsrfToken()}, 
             			url  : '$url',
             			success  : function(response) {
             			$('#modal .title').html('ส่งงาน');
             			$('#modal').modal('show')
             			$('#modal .modal-body').html(response); 
             	}
             	});return false;",
             			'data-pjax' => '0',
             	]);
             
             },
        
             ], 
            [
            		'class' => 'yii\grid\ActionColumn',
            		'template'=>'{view} {update} {delete}',
            		'visibleButtons' => [
            				'update' => function ($model, $key, $index) {
            					return $model->work_status == 3 ? false : true;
            				},
            				'delete' => function ($model, $key, $index) {
            					return ( $model->work_status == 3 || $model->is_delete==1 )? false : true;
            				}
            		]
            		
             ],
        ],
    ]); 

  
    
    ?>
<?php \yii\widgets\Pjax::end(); ?>
</div>
   <?php
   Modal::begin([
   'closeButton' => ['id' => 'close-button'],
   
   'options' => ['keyboard'=>false,
   		'id' => 'modal',
   		'tabindex' => false // important for Select2 to work properly
   ],
   		'header'=>'<h4 class="title">--</h4>',
   		//'id'=>'kartik-modal',
   		//'tabindex' => false , // important for Select2 to work properly
   		'size'=>'modal-lg',
   ]);
   
   echo "<div id='modalContent'></div>";
   Modal::end();
   ?>
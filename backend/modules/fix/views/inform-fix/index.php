<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\bootstrap\Modal;
use yii\helpers\BaseStringHelper;
use kartik\datecontrol\DateControl;
use common\models\Calendar;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\InformFixSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'แจ้งซ่อมบ้าน';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="inform-fix-index">

        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php \yii\widgets\Pjax::begin(['id' => 'p-inform-fixes']); ?>
        <?= GridView::widget([
            'id' => 'grid-inform-fixes',
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'columns' => [
                //   ['class' => 'yii\grid\SerialColumn'],

                'code',
                [
                    'attribute' => 'date_inform',
                    'value' => function($model) {
                        return \common\siricenter\thaiformatter\ThaiDate::widget([
                            'timestamp' => $model->date_inform,
                            'showTime' => false,
                        ]);
                    },
                ],

                [
                    'attribute' => 'project_id',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->project->name;

                    },
                ],
                [
                    'attribute' => 'home.plan_no',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<span class="badge">'. $model->home->plan_no .'</span>';
                    },
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'home.home_no',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->home->home_no;

                    },
                    'hAlign' => 'center',
                ],
                [
                    'attribute' => 'customer_name',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->prefixname . ' ' . $model->customer_name;
                    },
                ],
                // 'title',
                // 'description:ntext',
                [
                    'attribute' => 'id',
                    'label' => 'รายการแจ้ง',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $text = '';
                        if (count($model->informJobs) > 0) {
                            $i = 1;
                            foreach ($model->informJobs as $val) {
                                $text .= $i . ') ' . BaseStringHelper::truncate($val->list, 50) . '<br>';
                                $i++;
                            }
                        }
                        return '<small>' . $text . '</small>';
                    },
                ],

                [
                    'attribute' => 'home.date_insurance',
                    'format' => 'raw',
                    'hAlign' => 'center',
                    'value' => function ($data) {
                        $dateIns = \common\siricenter\thaiformatter\ThaiDate::widget([
                            'timestamp' => $data->home->date_insurance,
                            'showTime' => false,
                        ]);
                        $text = $data->home->date_insurance != '' ? $dateIns : '';
                        if ($data->home->date_insurance == '') {
                            $url = Url::to(['send-date-insurance', 'id' => $data->home_id]);
                            $text = Html::a('<i class="fa fa-calendar"></i> เพิ่มวันที่', $url, [
                                'class' => 'btn btn-info btn-xs',
                                'title' => \Yii::t('yii', 'ส่งงาน'),
                                'onclick' => "
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
                        }
                        return $text;

                    },
                ],

                [
                    'attribute' => 'work_status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->workStatus[$model->work_status];
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
                            $icon='<i class="glyphicon glyphicon-pencil"></i>';
                            $modelSen= Calendar::findOne(
                                ['table_name' => 'fix_inform_fix','table_key'=>$data->id ] ) ;
                            if ($modelSen)
                                $url=Url::to(['/fix/work-event/update','id'=>$modelSen->id]) ;
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
                    'format' => 'raw',
                    'value' => function ($data) {
                        $text = $data->is_send ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
                        $url = Url::to(['/fix/inform-fix/send-user', 'id' => $data->id]);
                        return Html::a('<i class="fa fa-send"></i>  ส่งเอกสาร', $url, [
                            'class' => 'btn btn-default btn-xs',
                            'title' => \Yii::t('yii', 'ส่งงาน'),
                            'onclick' => "
             			$.ajax({
             			type     :'POST',
             			cache    : false,
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
                    'template' => '{view} {update} {delete}',
                    'visibleButtons' => [
                        'update' => function ($model, $key, $index) {
                            return $model->is_send == 1 ? false : true;
                        },
                        'delete' => function ($model, $key, $index) {
                            return ($model->is_send == 1 || $model->is_delete == 1) ? false : true;
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
    'options' => [
        'id' => 'modal',
        'tabindex' => false // important for Select2 to work properly
    ],
    'header' => '<h4 class="title">--</h4>',
    //'id'=>'kartik-modal',
    //'tabindex' => false , // important for Select2 to work properly
    'size' => 'modal-lg',
]);

echo "<div id='modalContent'></div>";
Modal::end();
?>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\qtn\Models\SendDocumentsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Send Documents';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="send-documents-index">
    <?php \yii\widgets\Pjax::begin(['id' => 'p-inform-fixes']); ?>
    <?= GridView::widget([
        'id' => 'p-send-documents',
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'table_name',
                'label' => 'ประเภท',
                'format' => 'raw',
                'value' => function ($data) {
                    $text = '';
                    if ($data->table_name == 'fix_inform_fix') {
                        $text = 'แจ้งซ่อมบ้าน';
                    }

                    return $text;
                }
            ],
            //'table_key',

            'send_user_name',
            // 'send_at',
            // 'send_user_name',
            // 'recipient_user_id',
            // 'recipient_user_name',
            // 'recipient_at',
            [
                'attribute' => 'option',
                'label' => 'รายการ',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->listOption;
                },

            ],
            [
                'attribute' => 'option',
                'label' => 'รายละเอียด',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->detailOption;

                }
            ],
            'title',
            [

                'attribute' => 'is_khow',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->is_khow == 1) {
                        $m_re = '<div class="text text-success"><i class="fa  fa-check-square"></i> รับทราบแล้ว</div>';
                    } else {
                        $m_re = '<div class="text text-warning"><i class="fa  fa-check"></i> รอรับทราบ</div>';
                    }
                    $url = Url::to(['/fix/send-documents/send-acknowledge', 'id' => $data->id]);

                    if ($data->is_khow == 0) {
                        $m_re = Html::a('รับทราบ', $url, [
                            'title' => \Yii::t('yii', 'รับทราบ'),
                            'onclick' => "
             			$.ajax({
	             			type     :'POST',
	             			cache    : false,
	             			url  : '$url',
	             			success  : function(response) {
		             			$('#modal .title').html('รับทราบ');
		             			$('#modal').modal('show')
		             			$('#modal .modal-body').html(response);
				             }
			             });return false;",
                            'data-pjax' => '0',
                        ]);


                    }
                    return $m_re;

                },

            ],
            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
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

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgPersonnelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บุคลากร';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <?php
            Modal::begin([
                'options' => [
                    'id' =>'modal-customer',
                ],
                'toggleButton' => [
                    'label' => '<i class="fa fa-search"></i>',
                    'class' => 'btn btn-default'
                ],
                'closeButton' => [
                    'label' => 'Close',
                    'class' => 'btn btn-danger btn-sm pull-right',
                ],
                'size' => 'modal-sm',
            ]);
            echo $this->render('_search', ['model' => $searchModel]);
            Modal::end();
            ?>
            <?= Html::a('<i class="fa fa-plus"></i> เพิ่มบุคคากร', ['create'], ['class' => 'btn btn-success']) ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

<?php Pjax::begin(); ?>
<div class="table-responsive">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //   'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'photo',
                'value' => function ($model){
                    return ($model->photo)?Html::img($model->photoThumbnailLink,['class'=>'img img-responsive img-thumbnail','width'=>75]):'';
                },
                'format'=> 'raw'
            ],
            'code',
            // 'firstname_th',
            //'lastname_th',
            'fullnameTH:ntext',
            // 'first_name_th',
            // 'first_name_en',
            // 'middle_name_th',
            // 'middle_name_en',
            // 'last_name_th',
            // 'last_name_en',
            // 'birth_day',
            // 'day_probation',
            // 'work_status',
            'age',
            'workStatusName:ntext',
            'workTypeName:ntext',
            // 'nationality',
            // 'race',
            // 'religion',
            // 'idcard',
            // 'blood',
            // 'status_living',
            // 'marriage_status',
            // 'idcard_province_id',
            // 'idcard_amphur_id',
            // 'idcard_day_end',
            // 'military_status',
            // 'updated_at:datetime',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            [
                'attribute' => 'user.email',
                'format'=>'html',
                'value' =>  function($model){
                    return Html::a(@$model->user->email,"mail::".@$model->user->email);
                }
            ],
            'active:boolean',
            [
                'header' => 'เข้าสู่ระบบได้',
                'format' => 'raw',
                'value' => function($model){
                    if($model->user && $model->user->username == $model->code){
                        return '<span class="text-success"><i class="fa fa-unlock-alt"></i> สามารถ login</span>';
                    }else{
                        return '<span class="text-warning"><i class="fa fa-warning"></i> ไม่มี username</span>';
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
<?php Pjax::end(); ?>

    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->

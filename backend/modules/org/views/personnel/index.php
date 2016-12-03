<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgPersonnelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บุคลากร';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-personnel-index">

    <p>
        <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
     //   'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'photo',
                'value' => function ($model){
                    return ($model->photo)?Html::img($model->photoThumbnailLink,['class'=>'img img-responsive img-thumbnail']):'';
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
<?php Pjax::end(); ?></div>

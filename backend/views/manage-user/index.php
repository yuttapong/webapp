<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ผู้ใช้งาน');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'เพิ่มผู้ใช้งาน'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
            'heading' => $this->title,
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
             'email:email',
             [
               'attribute'=>'status',
               'format'=>'html',
               'filter'=>$searchModel->itemStatus,
               'value'=>function($model){
                 return $model->statusName=='Active' ?'<span class="text-success">'.$model->statusName.'</span>' : $model->statusName ;
               }
             ],
             'created_at:dateTime',
            // 'updated_at',

            [
              'class' => 'yii\grid\ActionColumn',
              'options'=>['style'=>'width:200px;'],
              'buttonOptions'=>['class'=>'btn btn-default'],
              'template'=>'<div class="btn-group btn-group-sm text-center" role="group">{role} {view} {update} {delete} </div>',
                'buttons'=>[
                    'role' => function($url,$model,$key){
                        return Html::a('<i class="glyphicon glyphicon-duplicate"></i>',$url,['class'=>'btn btn-default']);
                    }
                ]

            ],
        ],
    ]); ?>

</div>

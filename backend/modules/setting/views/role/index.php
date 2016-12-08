<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('setting.role', 'ผู้ใช้งาน');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">User</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('setting.role', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
        <div class="table-responsives">
        <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id',
                'format' => 'html',
                'value' => function($model, $key,$index) {
                    return Html::a($model->id,['view','id'=>$model->id]);
                }
            ],

            [
                'attribute' => 'username',
                'format' => 'html',
                'value' => function($model, $key,$index) {
                    return Html::a($model->username,['view','id'=>$model->id]);
                }
            ],
            'email:email',
            [
                'attribute' => '_fullname',
                'value' => 'personnel.fullnameTH',
            ],

             [
               'attribute' => 'created_at',
                 'format' => 'raw',
                 'value' => function($model) {
                    return  '<small>'.($model->created_at>0?Yii::$app->formatter->asDatetime($model->created_at, 'medium'):null).'</small>';
                 }
             ],
            // 'updated_at',
            // 'access_token',
            // 'logged_in_ip',
            // 'logged_in_at',
            // 'banned_reason',
            [
                'attribute' => 'status',
                'format' => 'html',
                'filter' => $searchModel->getItemStatus(),
                'value' => 'statusName',
            ],
            [
                'header' => 'HR Status',
                'value' => 'personnel.workStatusName'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
            ],
        ],
    ]); ?>
        </div>
    <?php Pjax::end(); ?>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- box-footer -->
    </div><!-- /.box -->
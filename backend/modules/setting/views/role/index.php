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
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'username',
            [
                'attribute' => '_fullname',
                'value' => 'personnel.fullnameTH',
            ],
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',

             'statusName',
             [
               'attribute' => 'created_at',
                 'value' => function($model) {
                    return  $model->created_at>0?Yii::$app->formatter->asDatetime($model->created_at, 'medium'):null;
                 }
             ],
            // 'updated_at',
            // 'access_token',
            // 'logged_in_ip',
            // 'logged_in_at',
            // 'banned_reason',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        </div><!-- /.box-body -->
        <div class="box-footer">

        </div><!-- box-footer -->
    </div><!-- /.box -->
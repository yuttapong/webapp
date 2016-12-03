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
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('setting.role', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            'role_id',
            'username',
            'personnel.firstname_th',
            [
                'attribute' => '_fullname',
                'value' => 'personnel.fullnameTH',
            ],
            // 'auth_key',
            // 'password_hash',
            // 'password_reset_token',
            'email:email',

             'statusName',
             'created_at:datetime',
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
    <?php Pjax::end(); ?></div>

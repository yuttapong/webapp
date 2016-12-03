<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */

$this->title = $model->personnel->fullnameTH . " ({$model->username})";
$this->params['breadcrumbs'][] = ['label' => Yii::t('setting.role', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('setting.role', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('setting.role', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger hidden',
            'data' => [
                'confirm' => Yii::t('setting.role', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="col-xs-12 col-sm-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'role_id',
                'username',
                'email:email',
                'statusName',
                'created_at:datetime',
                'updated_at:datetime',
                'logged_in_ip',
                'logged_in_at:datetime',
                'banned_reason',
            ],
        ]) ?>

    </div>
    <div class="col-xs-12 col-sm-6">
        <?php
        foreach ($modules as $module) {
            $mark = '<i class="fa fa-close"></i>';
            if (in_array($module->id, $userModule)) {
                $mark =  '<i class="fa fa-check"></i>';
            }
            echo Html::tag('p', $mark  . ' ' .  $module->name_th);
        }
        ?>

    </div>

    <div class="col-xs-12 col-sm-6 col-md-6">
        Roles:
        <?php
        print_r($model->getRoleByUser());
        ?>
    </div>

</div>

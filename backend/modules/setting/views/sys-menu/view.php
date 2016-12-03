<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SysMenu */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sys Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-menu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'module_id',
            'is_header:boolean',
            'name',
            'parent',
            'route',
            'order',
            'data:ntext',
            'url:url',
            'created_at:datetime',
            'created_by',
        ],
    ]) ?>

</div>

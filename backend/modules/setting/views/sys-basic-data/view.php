<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SysBasicData */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ชุดข้อมูลพื้นฐาน', 'url' => ['sys-table/index']];
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Basic Datas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-basic-data-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'table_id',
            'code',
            'name',
            'status',
            'create_at',
            'create_id',
        ],
    ]) ?>

</div>

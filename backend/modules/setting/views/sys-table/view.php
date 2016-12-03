<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;
//use yii\grid\GridView;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model backend\models\SysTable */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ชุดข้อมูลพื้นฐาน'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-table-view">
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
<div class="well">
    <div class="row">
        <div class="col-sm-4">
            <label>รายละเอียด:</label> <?=$model->detail?>
        </div>
        <div class="col-sm-4">
            <label>สถานะ:</label> <?=$model->status?>
        </div>
        <div class="col-sm-4">
            <label>แก้ไขเมื่อ:</label> <?=Yii::$app->formatter->asDatetime($model->updated_at)?>
        </div>
    </div>




</div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'sub',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'code',
            [
                'filter' => true,
                'attribute' => 'name',
                'format' => 'html',
            ],
            [
                'attribute' => 'status',
                'class' => '\kartik\grid\BooleanColumn',
                'trueLabel' => 'Yes',
                'falseLabel' => 'No'
            ],
           // ['class' => 'yii\grid\ActionColumn'],

        ],
        'responsive'=>true,
        'hover'=>true
    ]); ?>


</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\orgPart */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->orgDivision->name,
    'url' => ['parts','division_id'=>$model->orgDivision->id]
];
//$this->params['breadcrumbs'][] = ['label' => 'ส่วนงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-part-view">


    <p>
        <?= Html::a('Update', ['update-part', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-part', 'id' => $model->id], [
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
            'orgDivision.name',
            'name',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ]) ?>

</div>

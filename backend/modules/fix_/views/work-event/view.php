<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Work Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-event-view">


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
            'title',
            'description',
            'start_date',
            'end_date',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => $model->status == '1'? '<span class="app-status label label-success" >'.$model->statusName.'</span>' : '<span class="app-status label label-danger" > '. $model->statusName .'</span>',
            ]

        ],
    ]) ?>

</div>

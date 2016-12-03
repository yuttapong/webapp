<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\home */

$this->title = $model->project->name. " :: แปลง {$model->plan_no}";
$this->params['breadcrumbs'][] = ['label' => 'Homes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-view">

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

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'project.name',
                    'plan_no',
                    'home_no',
                    'status:boolean',
                    'type',
                    'home_prices',
                    'land',
                    'use_area',
                ],
            ]) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'customer_id',
                    'customer_name',
                    'created_at:datetime',
                    'created_by',
                    'updated_at:datetime',
                    'updated_by',
                ],
            ]) ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'statusBooking',
                        'statusContract',
                        'statusTransfer',
                        'date_insurance',
                    ],
                ]) ?>
        </div>
    </div>


</div>

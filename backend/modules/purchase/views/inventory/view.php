<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


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
    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'master_id',
                'categories_id',
                'code',
                'type',
                'name',
                'unit_id',
                'unit_name',
                'comment:ntext',
            ],
        ]) ?>
    </div>

    <div class="col-md-6">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => ($model->status == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger'])
                ],
                'create_at',
                'create_by',
                'update_at',
                'update_by',
            ],
        ]) ?>
    </div>
</div>

<hr>

<table class="table">
    <tr>
        <th>#</th>
        <th>Code</th>
        <th>Vendor</th>
        <th><div align="right">ราคา</div></th>
        <th><div align="center">จำนวนที่จะส่งของได้</div></th>
        <th>Status</th>
    </tr>
    <?php
    if ($model->prices) {
        foreach ($model->prices as $key => $price) {
            ?>
            <tr>
                <td><?=$key+1?></td>
                <td><?= $price->vendor->code ?></td>
                <td><?= $price->vendor->company ?></td>
                <td align="right"><?= Yii::$app->formatter->asDecimal($price->price, 2) ?></td>
                <td align="center"><?= $price->due_date ?></td>
                <td><?= ($price->status == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger']) ?></td>
            </tr>
            <?php
        }
    }
    ?>
</table>




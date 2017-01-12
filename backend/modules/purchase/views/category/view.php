<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\models\Categories */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('purchase.category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('purchase.category', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('purchase.category', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('purchase.category', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'code',
            'name',
            'create_at',
            'create_by',
            'upadte_at',
            'update_by',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'filter' => [
                    0 => 'Inactive',
                    1 => 'Active'
                ],
                'value' =>  ($model->status == 1) ? Html::tag('span', 'Active', ['class' => 'label label-success']) : Html::tag('span', 'Inactive', ['class' => 'label label-danger'])
            ],
        ],
    ]) ?>

</div>

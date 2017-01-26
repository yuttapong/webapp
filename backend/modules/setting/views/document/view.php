<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SysDocument */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sys Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-document-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->document_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->document_id], [
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
            'document_id',
            'name',
            'description:ntext',
            'document_status',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'table_name',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\orgDivision */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ฝ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-division-view">


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
            'name',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by'
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\SendDocuments */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Send Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="send-documents-view">

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
            'table_name',
            'table_key',
            'title',
            'send_user_id',
            'send_at',
            'send_user_name',
            'recipient_user_id',
            'recipient_user_name',
            'recipient_at',
            'option:ntext',
            'is_khow',
        ],
    ]) ?>

</div>

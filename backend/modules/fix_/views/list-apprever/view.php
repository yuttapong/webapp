<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\ListApprover */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'List Apprevers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-apprever-view">

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
            'inform_fix_id',
            'approver_user_id',
            'approver_seq',
            'user_next_id',
            'description:ntext',
            'created_at',
            'created_by',
            'approval_status',

        ],
    ]) ?>

</div>
<?php 
#$model->informMaterial;
$iv=1;
foreach ($model->informMaterial as $val){
	echo $iv.' '.$val->name.' '.$val->qty.' '.$val->unit.'<br>';
	$iv++;
}
?>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\InformJob */

$this->title = $model->list;
$this->params['breadcrumbs'][] = ['label' => 'Inform Jobs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inform-job-view">

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
           // 'id',
           // 'inform_fix_id',
            'list',
            'description:ntext',
           // 'status',
           // 'job_list_id',
           // 'created_at',
          //  'created_by',
          //  'responsible_id',
           // 'responsible_name',
          //  'job_status',
           // 'pate_price',
            //'net_price',
          // 'apprever_type',
        ],
    ]) ?>

</div>
    <?php 
if(count($model->material)>0){
	$inv=1;
	foreach ($model->material as $mat){
		echo $inv.'. '.$mat->name.'<br>';
		$inv++;
	}
	
}
?>

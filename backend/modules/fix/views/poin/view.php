<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\Poin */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Poins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poin-view">

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
           
            'title',
            'site_id',
            'project_id',
            'code',
            'user_order_id',
      
        ],
    ]) ?>

</div>
<?php     $gridColumns = [
		
		['class' => 'yii\grid\SerialColumn'],
		'inventory_name',
		'qty',
		'home_id',
		'unit_name',
		'job_name',
];
 echo GridView::widget([
        'dataProvider' => $dataProvider,
     
        'columns' =>$gridColumns,
    ]);

?>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\PoinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Poins';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Poin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'site_id',
            'project_id',
            'code',
            // 'user_order_id',
            // 'create_at',
            // 'create_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

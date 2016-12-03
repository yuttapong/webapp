<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\PrinSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prins';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="prin-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prin', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'code',
            'title',
            'description:ntext',
            'type',
            // 'user_order_id',
            // 'create_at',
            // 'create_by',
            // 'site_id',
            // 'project_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

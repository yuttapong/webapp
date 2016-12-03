<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\fix\Models\ListApproverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Apprevers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-apprever-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create List Apprever', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'list',
            //'inform_fix_id',
            'approver_user_id',
            'approver_seq',
            'user_next_id',
            // 'description:ntext',
            // 'created_at',
            // 'created_by',
            // 'approval_status',
            // 'table_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

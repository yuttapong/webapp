<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\Models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sys Documents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-document-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sys Document', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'description:ntext',
            'document_status',
            [
                'label' => 'ตั้งค่าอนุมัติ',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('ตั้งค่าผู้อนุมัติ', ['config', 'id' => $model->document_id, 'company_id' => '1']);
                },

            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => [
                    'setting' => '',
                ],
            ],
        ],
    ]); ?>
</div>

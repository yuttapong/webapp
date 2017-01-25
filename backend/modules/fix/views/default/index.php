<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ListMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ข้อความ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-message-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'document_id',
                'label' => 'รายการ',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->documents->name;

                }],
            [
                'attribute' => 'title',
                'label' => 'รายการ',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->title;

                }],
            [
                'attribute' => 'description',
                'label' => 'รายละเอียด',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->description;

                }],
            [
                'attribute' => 'link',
                'label' => 'ดูเอกสาร',
                'format' => 'raw',
                'value' => function ($data) {
                    $link = Html::a('<span class="glyphicon glyphicon-eye-open"></span>', [$data->link]);
                    return $link;

                }],
        ],
    ]); ?>
</div>
<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\SysTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'ชุดข้อมูลพื้นฐาน');
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-table-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'เพิ่มชุดข้อมูลพื้นฐาน'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'pjax' => true,
        'hover' => true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',

            [
                'attribute' => 'name',
            ],
            'slug',
            'detail:ntext',
            [
                'header' => 'จำนวนข้อมูล',
                'value' => function ($data) {
                    return count($data->sysBasicDatas);
                },
            ],
            [
                'attribute' => 'status',
                'class' => '\kartik\grid\BooleanColumn',
                'trueLabel' => 'Yes',
                'falseLabel' => 'No'
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

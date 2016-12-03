<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\Block;
use kartik\sidenav\SideNav;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ฝ่าย';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="org-division-index">
    <p>
        <?= Html::a('สร้างฝ่าย', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' =>function($data){
                    return Html::a($data->name,['division/parts','division_id'=>$data->id]);
                }
            ],
            [
                'header' => 'จำนวนส่วนงาน',
                'value' => function($model){
                    return  $model->countPart;
                }
            ],
            [
                'header' => 'จำนวนแผนก',
                'value' => function($model){
                    return  $model->countDepartment;
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

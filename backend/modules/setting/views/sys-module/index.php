<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use common\models\SysBasicData;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\SysModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'โมดูล';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="sys-module-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่มข้อมูลโมดูล', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'bordered' => false,
        'pjax' => false,
        'hover' => true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute' => 'img',
              'format' => 'html',
              'value' => function($model)  {
                 $icon = '';
                 if($model->img) {
                     $icon =   '<div align="center"><i class="fa-2x '.($model->img).'"></i></div>';
                 }
                 return $icon;
            },
            'options' => [
                'style' => 'width:80px;'
              ]
            ],
            'slug',
            /*
            [
                'attribute' => 'name_th',
                'value' => function ($model) {
                    return Html::a($model->name_th, [$model->url], ['target' => '_blank']);
                },
                'format' => 'raw',
            ],
             */
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name_th',
                'pageSummary' => 'Page Total',
                'hAlign' => 'left',
                'headerOptions' => ['class' => 'kv-sticky-column'],
                'contentOptions' => ['class' => 'kv-sticky-column'],
                'editableOptions' => [
                    'header' => 'Name',
                    'size' => 'sm',
                    'formOptions' => ['action' => ['sys-module/editModule']]
                ]
            ],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'name_en',
                'pageSummary' => 'Page Total',
                'headerOptions' => ['class' => 'kv-sticky-column'],
                'contentOptions' => ['class' => 'kv-sticky-column'],
                'editableOptions' => [
                    'header' => 'Name',
                    'size' => 'sm',
                    'formOptions' => ['action' => ['sys-module/editModule']]
                ]
            ],
            'url',
            //  'updated_at:dateTime',
            [
                'class' => \kartik\grid\EditableColumn::className(),
                'attribute' => 'active',
                'editableOptions' => [
                    'header' => 'สถานะ',
                    'size' => 'sm',
                    'formOptions' => ['action' => ['sys-module/editModule']]
                ]
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

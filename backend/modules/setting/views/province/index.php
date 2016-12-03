<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\SysProvinceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'จังหวัด';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-province-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Sys Province', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'code',
            'name_th',
            [
                'header' => 'จำนวนอำเภอ',
                'value' => 'countAmphur',
            ],
            [
                'header' => 'จำนวนตำบล',
                'value' => 'countTambon',
            ],
            [
                'attribute' => 'geography_id',
                'value'=>'geography.name_th',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>\common\models\SysGeography::getArrayGeoGraphy(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'หมวดหมู่'],
                'group'=>false,  // enable grouping
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'active',
                'vAlign'=>'middle',
            ],

            // 'created_at',
            // 'created_by',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

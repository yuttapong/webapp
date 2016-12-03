<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\SysAmphurSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'อำเภอ';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-amphur-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Sys Amphur', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'name_th',
            [
                'attribute' => 'province_id',
                'value'=>'province.name_th',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>\common\models\SysProvince::getArrayProvince(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'-จังหวัด-'],
                'group'=>false,  // enable grouping
            ],
            [
                'attribute' => 'geography_id',
                'value'=>'geography.name_th',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>\common\models\SysGeography::getArrayGeoGraphy(),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'ภาค'],
                'group'=>false,  // enable grouping
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'active',
                'vAlign'=>'middle',
            ],
            // 'master_id',
            // 'create_at',
            // 'create_by',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

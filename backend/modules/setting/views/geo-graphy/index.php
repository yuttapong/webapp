<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\SysGeoGraphySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ภาค';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-geo-graphy-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //Html::a('เพิ่มภาค', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            'name_th',
            'name_en',
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'active',
                'vAlign'=>'middle',
            ],
            [
                'header' => 'จังหวัด',
                'value' => 'countProvince',
            ],
            [
                'header' => 'อำเภอ',
                'value' => 'countAmphur',
            ],
            [
                'header' => 'ตำบล',
                'value' => 'countTambon',
            ],
            // 'create_time:datetime',
            // 'create_by',

           // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

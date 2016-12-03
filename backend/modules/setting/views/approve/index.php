<?php
/* @var $this yii\web\View */


$this->title = 'การอนุมัติ';
$this->params['breadcrumbs'][] = $this->title;
use kartik\form\ActiveForm;


use kartik\helpers\Html;
use kartik\widgets\SwitchInput;
use kartik\grid\GridView;

?>
<?= GridView::widget([
    'bordered' => false,
    'pjax' => false,
    'hover' => true,
    'dataProvider' => $dataProvider,
    // 'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'site_id',
        [
            'attribute' => 'site_name',
            'value' => function($model){
                return Html::a($model->site_name,['site','site_id'=>$model->site_id]);
            },
            'format' => 'raw'
        ],

        'company.name'
    ],
]);
?>



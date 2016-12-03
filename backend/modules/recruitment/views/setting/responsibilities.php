<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'หน้าที่รับผิดชอบ';
$this->params['breadcrumbs'][] = 'ตั้งค่า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rcm-setting-index">
    
    <p>
        <?php /* echo Html::a('Create Rcm Setting', ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'title',
                'pageSummary' => 'Page Total',
                'vAlign' => 'left',
                'headerOptions' => ['class' => 'kv-sticky-column'],
                'contentOptions' => ['class' => 'kv-sticky-column'],
                'editableOptions' => [
                    'header' => 'Title',
                    'size' => 'lg',
                    'formOptions' => ['action' => ['setting/edittitle']]
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '',
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],



    ]); Pjax::end(); ?>

</div>

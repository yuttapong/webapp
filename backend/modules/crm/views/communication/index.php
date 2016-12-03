<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CommunicationSearch $searchModel
 */

$this->title = Yii::t('crm.communication', 'ประวัติการติดตามลูกค้า');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="communication-index">
    <div class="page-header">
            <h1><i class="fa fa-commenting"></i>  <?= Html::encode($this->title) ?></h1>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php /* echo Html::a(Yii::t('crm.communication', 'Create {modelClass}', [
    'modelClass' => 'Communication',
]), ['create'], ['class' => 'btn btn-success'])*/  ?>
    </p>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'datetime:datetime',
            'detail:ntext',
            [
                'header' => 'ลูกค้า',
                'value' =>'customer.fullname',
            ],
            'createdName',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                'update' => function ($url, $model) {
                                    return Html::a('<span class="fa fa-edit"></span>', Yii::$app->urlManager->createUrl(['communication/view','id' => $model->id,'edit'=>'t']), [
                                                    'title' => Yii::t('yii', 'Edit'),
                                                  ]);}

                ],
            ],
        ],
        'responsive'=>true,
        'hover'=>true,
        'condensed'=>true,
        'floatHeader'=>true,



/*
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type'=>'info',
            'before'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter'=>false
        ],*/
    ]); Pjax::end(); ?>

</div>

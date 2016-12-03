<?php

use yii\bootstrap\Html;
use kartik\grid\GridView;
use common\helpers\UrlRule;
use backend\modules\qtn\models\Question;
use kartik\tabs\TabsX;
use backend\modules\qtn\models\QuestionType;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CustomerSearch $searchModel
 */

$this->title = 'ประเภทแบบสอบถาม';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-index">
    <h1><i class="fa fa-list"></i> <?= $this->title ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php echo Html::a('สร้าบแบบสอบถามใหม่', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $campuses = \backend\modules\org\models\OrgSite::find()->orderBy('site_name')->asArray()->all();
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'site_id',
                'filter' => Html::activeDropDownList($searchModel, 'site_id', $searchModel->siteItems, [
                    'class' => 'form-control',
                    'prompt' => '--เลือกไซต์งาน/โครงการ--'
                ]),
                'value' => 'site.site_name'
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, ['view', 'id' => $model->id], [
                        'title' => Yii::t('yii', 'Edit'),
                    ]);
                }
            ],
            [
                'header' => 'จำนวนแบบสอบถาม',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<span class="badge">' . count($model->questionnaires) . '</span>', ['user', 'id' => $model->id], [
                        'title' => Yii::t('yii', 'Edit'),
                    ]);
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template'=>'<div class="btn-group btn-group-sm text-center" role="group">{update} {view} {export}</div>',
                'buttons' => [
                    'export' => function ($url, $model, $key) {
                        return Html::a('<i class="glyphicon glyphicon-export"></i>', ['report/excel','id'=>$model->id],[
                            'target' => '_blank',
                        ]);
                    }
                ]
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,

        /*
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> ' . Html::encode($this->title) . ' </h3>',
            'type' => 'default',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
        */
    ]);
  ?>

</div>


<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \yii\widgets\Pjax::begin();?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Project', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function($model, $key, $index, $grid) {
                return [
                    'id' => $model['id'],
                    'onclick' => 'window.location.href=\'update?id='.'\'+(this.id);',
                    'style' => 'cursor:pointer'
                ];
            },
            'columns' => [
               // ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    // you may configure additional properties here
                ],
                'id',
                'name',
                [
                    'attribute' => 'site_id',
                    'filter' => $searchModel->getSiteItems(),
                    'value' => 'site.site_name',
                ],
                [
                    'attribute' => 'company_id',
                    'filter' => $searchModel->getCompanyItems(),
                    'value' => 'company.name',
                ],
               [
                 'attribute' => 'status',
                   'filter' => $searchModel->getStatusItems()
               ],
                // 'type',
                // 'created_at',
                // 'created_by',
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
    </div>

    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->

<?php \yii\widgets\Pjax::end();?>


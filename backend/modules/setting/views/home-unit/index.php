<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\setting\models\HomeUnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Homes';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php \yii\widgets\Pjax::begin();?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <?php
            Modal::begin([
                'toggleButton' => [
                    'label' => '<i class="glyphicon glyphicon-plus"></i> Add',
                    'class' => 'btn btn-success'
                ],
                'closeButton' => [
                    'label' => 'Close',
                    'class' => 'btn btn-danger btn-sm pull-right',
                ],
                'size' => 'modal-lg',
                'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
            ]);
            $myModel = new \common\models\Home();
            echo $this->render('_form', ['model' => $myModel]);
            Modal::end();
            ?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Home', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'project_id',
                'value' => 'project.name',
                'filter' => $searchModel->getProjectItems(),
            ],
            [
                'attribute' => 'plan_no',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->plan_no,['view','id'=>$model->id],[
                        'class' => 'badge'
                    ]);
                }
            ],
            [
                'attribute' => 'home_no',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->home_no,['view','id'=>$model->id],[
                        'class' => ''
                    ]);
                }
            ],
            'customer_name',
            [
                'attribute' => 'status',
                'value'     => function ($model, $key, $index, $column) {
                    return $model->statusName;
                },
                'filter'    => $searchModel->getStatusItems(),
            ],
            // 'type',
            // 'home_prices',
            // 'land',
            // 'use_area',
            // 'home_status',
            // 'compact_status',
            // 'transfer_status',
            // 'created_at',
            // 'created_by',
            [
                'attribute' => 'date_insurance',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->date_insurance,
                        'showTime' => false,
                    ]);
                }
            ],
            [
                'attribute' => 'updated_at',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->updated_at,
                        'showTime' => true,
                    ]);
                }
            ],
            [
                'attribute' => 'date_insurance',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->date_insurance,
                        'showTime' => false,
                    ]);
                }
            ],


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->



<?= Html::button('Create New Company', [
    'value' => Url::to(['create']),
    'title' => 'Creating New Company',
    'class' => 'loadMainContent btn btn-success'
]); ?>


<?php
yii\bootstrap\Modal::begin([
    'headerOptions' => ['id' => 'modalHeader'],
    'id' => 'modal',
    'size' => 'modal-lg',
    //keeps from closing modal with esc key or by clicking out of the modal.
    // user must click cancel or X to close
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE]
]);
echo "<div id='main-content'><i class=\"fa fa-spinner fa-spin fa-3x fa-fw\"></i><span class=\"sr-only\">Loading...</span></div>";
yii\bootstrap\Modal::end();

$this->registerJs("
 $(document).on('click', '.loadMainContent', function(){
           $('#main-content').load($(this).attr('value'));
           $('#modal').modal('show');
    });
");
?>

<?php \yii\widgets\Pjax::end();?>
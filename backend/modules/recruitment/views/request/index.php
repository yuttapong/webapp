<?php
use kartik\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\recruitment\models\RcmAppManpower;


/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\recruitment\models\RcmAppManpowerSearch $searchModel
 */
$this->title = 'ระบบสรรหาบุคคลากร';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rc-app-manpower-index">
    <?php Pjax::begin(); ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php /* echo Html::a('Create Rc App Manpower', ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'code',
            [
                'attribute' => 'position.name_th',
                'value' => function ($model) {
                    return Html::a("อนุมัติสมบูรณ์",['view','id'=>$model->id]);
                },
                'format' => 'html',
            ],
            // 'department.name',
            'date_to:date',
//            'approver_user_id',
//            'approver_seq',
//            'user_next_id', 
//            'company_id', 
//            'reason_request', 
//            'reason_request_text', 
//            'data_property:ntext', 
            //'status',
//            'log_status', 
//            ['attribute'=>'date_to','format'=>['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']], 
//            'salary', 
//            'qty', 
            'created_at:datetime',
             'requestBy',
            /*
            [
                'attribute' => 'log_status',
                'format' => 'html',
                'value' => function ($model, $key, $index, $column) {
                    return $model->log_status == RcmAppManpower::LOG_STATUS_ACTIVE
                        ? "<span style=\"color:green;\">Active</span>"
                        : "<span style=\"color:red;\">Deleted</span>";
                }
            ],
            */
            [
                'attribute' => 'status',
                //  'class' => \kartik\grid\BooleanColumn::className(),
                'value' => function ($model) {
                    $html = '';
                    if ($model->status == RcmAppManpower::APPROVE_NOT_COMPLETED) {
                        $html .= Html::bsLabel("อนุมัติยังไม่เสร็จ",'warning');
                    }
                    if ($model->status == RcmAppManpower::APPROVE_COMPLETED) {
                        $html .= Html::bsLabel("อนุมัติสมบูรณ์",'success');
                    }
                    return $html;
                },
                'format' => 'html',

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => "{update}  {delete}   {approve}  {view}",
                'options' => ['style' => 'width:200px'],
                'buttons' => [
                    'update' => function ($url, $model) {
                        if ($model->status == RcmAppManpower::APPROVE_NOT_COMPLETED)
                            return Html::a(Html::icon('edit'), ['update', 'id' => $model->id]);
                    },
                    'approve' => function ($url, $model) {
                        if ($model->status == RcmAppManpower::APPROVE_NOT_COMPLETED)
                            return Html::a(Html::icon('check'), ['approve', 'id' => $model->id]);
                    },
                ]
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="fa fa-list"></i> ' . Html::encode($this->title) . ' </h3>',
            'type' => GridView::TYPE_DEFAULT,
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']), 'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]);
    Pjax::end(); ?>

</div>

<?php


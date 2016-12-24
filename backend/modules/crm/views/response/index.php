<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\crm\models\ResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'แบบสอบถามลูกค้า';
$this->params['breadcrumbs'][] = ['label' => 'ลูกค้า', 'url' => ['customer/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="response-index">
    <?php
    Modal::begin([
        'id' => 'search-modal',
        'header' => '<h2>ค้นหา</h2>',
    ]);
    ?>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Modal::end() ?>


    <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-book"></i> <?= $this->title ?>
             <?php echo ($msg)?'('.$msg.')':'';?>
            <div class="box-tools pull-right">
                <?php
               echo  Html::button('<i class="fa fa-search"></i> ค้นหา', [
                    'class' => 'btn btn-default',
                    'data-toggle' => 'modal',
                    'data-target' => '#search-modal'
                ])
                ?>
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">


            <div class="table-responsive">


                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    //  'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        // 'id',
                        [
                            'header' => 'โครงการ',
                            'value' => 'survey.site.site_name',
                        ],
                        //'datetime:datetime',
                        [
                            'attribute' => 'datetime',
                            'value' => function ($model) {
                                return \common\siricenter\thaiformatter\ThaiDate::widget([
                                    'timestamp' => $model->datetime,
                                    'showTime' => false,
                                    'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                                ]);
                            }
                        ],
                        [
                            'attribute' => 'survey.name',
                            'value' => function ($model) {
                                return Html::a( $model->survey->name,['response/view','id'=>$model->id]);
                            },
                            'format' => 'raw',
                        ],
                        [
                            'header' => 'รหัสลูกค้า',
                            'value' => 'customer.id',
                        ],
                        'customer.fullname',
                        // 'customer.lastname',
                        // 'created_at:datetime',
                        [
                            'attribute' => 'created_at',
                            'value' => function ($model) {
                                return \common\siricenter\thaiformatter\ThaiDate::widget([
                                    'timestamp' => $model->created_at,
                                    'showTime' => true,
                                    'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                                ]);
                            }
                        ],
                        'created.firstname_th',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{customer} {view}',
                            'options' => [
                                'style' => 'width:80px',
                            ],
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-search"></i>',
                                        ['view', 'id' => $model->id],
                                        [
                                            'title' => 'ดูแบบสอบถุาม',
                                        ]
                                    );
                                },
                                'customer' => function ($url, $model) {
                                    return Html::a('<i class="fa fa-user"></i>',
                                        ['customer/view', 'id' => $model->table_key],
                                        [
                                            'title' => 'ข้อมูลลูกค้า',
                                        ]
                                    );
                                }
                            ]
                        ],

                    ]
                ]); ?>


            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
</div>
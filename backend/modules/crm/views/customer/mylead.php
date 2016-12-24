<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\bootstrap\ButtonGroup;
use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Nav;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\modules\crm\models\CustomerSearch $searchModel
 */


$this->title = 'ลูกค้าที่ฉันรับผิดชอบ';

$this->params['breadcrumbs'][] = $this->title;
?>
<?php
echo $this->render('toolbar/customer');
?>
<br>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$this->title?></h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="table-responsive">

<?php

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [

        ['class' => 'yii\grid\SerialColumn'],
        /*      [
                  'attribute' => 'active',
                  'format' => 'raw',
                  'value' => function($model){
                      return ($model->active)
                          ?'<span class="label label-success">Yes</span>'
                          :'<span class="label label-danger">No</span>';
                  }
              ],*/
        'customer.id',
        'customer.prefixname',
        [
            'attribute' => 'customer.fullname',
            'format' => 'html',
            'value' =>function($model) {
                    return Html::a($model->customer->fullname,
                        ['customer/view', 'id' => $model->customer_id]);         
            }
        ],
        //'firstname',
        //'lastname',
        'customer.mobile',
        'customer.tel',
        [
            'header' => 'ผู้รับผิดชอบ',
            'format' => 'raw',
            'value' => function($model) {
                return Html::tag('span','<i class="fa fa-user-circle-o"></i> '. $model->customer->currentPersonInCharge,['class' => '']);
            }
        ],
        [
            'header' => 'Assigned By',
            'value' => function($model){
                $time =  \common\siricenter\thaiformatter\ThaiDate::widget([
                    'timestamp' => $model->created_at,
                    'type' =>\common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                    'showTime' => true,
                ]);
                $by = $model->assignBy->firstname_th;
                return $by.'<br>'.$time;

            },
            'format' => 'html',
            'options' => [
                 'style' => 'text-align:center;',
            ]
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {view} {survey}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        ['update', 'id' => $model->customer_id], [
                            'title' => Yii::t('yii', 'Edit'),
                        ]);
                },
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-search"></span>',
                        ['customer/view', 'id' => $model->customer_id],
                        [
                            'title' => Yii::t('yii', 'ดูรายละเอียด'),
                        ]);
                }
            ],
            'options' => [
                'style' => 'width:100px;'
            ]
        ],
    ],
]);

?>




        </div><!-- /.box-body -->

    </div><!-- /.box -->





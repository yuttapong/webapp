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

<?php
 /*
 $this->render('_search', [
    'model' => $searchModel,
    'action' => ['mylead']
]);
 */
 ?>

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
        'customer.fullname',
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
        'user_id',
        'created_by',
        [
            'attribute' => 'customer.created_at',
            'value' => function($model){
                return \common\siricenter\thaiformatter\ThaiDate::widget([
                    'timestamp' => $model->created_at,
                    'type' =>\common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                    'showTime' => true,
                ]);

            }
        ],
        [
            'header' => 'ผู้บันทึก',
            'value' => 'personnel.firstname_th',
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {view}',
            'buttons' => [
                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        ['update', 'id' => $model->customer_id], [
                            'title' => Yii::t('yii', 'Edit'),
                        ]);
                },
                'survey' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-list"></span>',
                        ['customer/survey', 'customerId' => $model->customer_id],
                        [
                            'title' => Yii::t('yii', 'กรอกแบบสอบถาม'),
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








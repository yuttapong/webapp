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


$this->title = 'ข้อมูลลูกค้า';

$this->params['breadcrumbs'][] = $this->title;

?>
<?php
 echo $this->render('toolbar/customer');
?>
<br>

<?php
 \yii\widgets\Pjax::begin();
?>



    <?php echo $this->render('_search', [
        'model' => $searchModel,
        'action' => ['index']
        ]); ?>

<br>
    <?php

    echo ButtonDropdown::widget([
        'label' => 'เพิ่ม',
        'dropdown' => [
            'items' => [
                ['label' => '+ ลูกค้า', 'url' => 'create']
            ],
        ],
    ]);

    ?>
    <?php

    echo GridView::widget([

        'dataProvider' => $dataProvider,
        'columns' => [

            //['class' => 'yii\grid\SerialColumn'],
            /*      [
                      'attribute' => 'active',
                      'format' => 'raw',
                      'value' => function($model){
                          return ($model->active)
                              ?'<span class="label label-success">Yes</span>'
                              :'<span class="label label-danger">No</span>';
                      }
                  ],*/

            [
                'attribute' => 'id',
                'value' => function ($model) {
                    return Html::a($model->id, ['customer/view', 'id' => $model->id], ['title' => $model->fullname]);
                },
                'format' => 'raw',
            ],
            'prefixname',
            [
                'attribute' => 'fullname',
                'value' => function ($model) {
                    return Html::a($model->fullname, ['customer/view', 'id' => $model->id], ['title' => $model->fullname]);
                },
                'format' => 'raw',
            ],

            //'firstname',
            //'lastname',
            /*
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'ดูแบบสอบถาม',
                'collapseTitle' => 'แบบสอบถาม',
                'expandIcon' => '<i class="fa fa-book"></i>',
                'value' => function ($model, $key, $index, $column) {
                    return GridView::ROW_COLLAPSED;
                },
                'detailUrl' => Url::to(['customer/questionnare-detail']),
                'detailRowCssClass' => GridView::TYPE_INFO,
                'pageSummary' => false,
            ],
            */
            [
                'header' => 'แบบสอบถาม',
                'value' => 'countQuestionnaire',
            ],
            'mobile',
            'tel',
            //'email',
            [
                'header' => 'เยี่ยมชมเมื่อ',
                'value' => function ($model) {
                    $response = \backend\modules\crm\models\Response::find()
                        ->where(['table_key' => $model->id])
                        ->orderBy(['id' => SORT_ASC])
                        ->limit(1)
                        ->one();
                    if ($response)
                        return \common\siricenter\thaiformatter\ThaiDate::widget([
                            'timestamp' => $response->datetime,
                            'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                        ]);
                }
            ],
            [
                'header' => 'ผู้รับผิดชอบ',
                'format' => 'raw',
                'value' => function($model) {
                    return Html::tag('span','<i class="fa fa-user-circle-o"></i> '. $model->currentPersonInCharge,['class' => '']);
                }
            ],
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return \common\siricenter\thaiformatter\ThaiDate::widget([
                        'timestamp' => $model->created_at,
                        'type' => \common\siricenter\thaiformatter\ThaiDate::TYPE_SHORT,
                        'showTime' => true,
                    ]);

                }
            ],
            [
                'header' => 'ผู้บันทึก',
                'value' => 'createdName',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            ['update', 'id' => $model->id], [
                                'title' => Yii::t('yii', 'Edit'),
                            ]);
                    },
                    'survey' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list"></span>',
                            ['customer/survey', 'customerId' => $model->id],
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
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => false,
    ]);

    ?>




<?php \yii\widgets\Pjax::end()?>


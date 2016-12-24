<?php
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\crm\models\ResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'เลือกแบบสอบถาม - Choose Questionnaire';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelCustomer->fullname, 'url' => ['view', 'id' => $modelCustomer->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">

            <?=Html::a($modelCustomer->fullname. '  (ID#'.$modelCustomer->id.')',['customer/view','id'=>$modelCustomer->id],[
                'title' => $modelCustomer->fullname,

            ])?>
        </h3>
        <div class="box-tools pull-right">

            <?=Html::a('<i class="fa fa-arrow-left"></i> ฺBack',['customer/view','id'=>$modelCustomer->id],[
                'title' => 'Back to :: ' . $modelCustomer->fullname,
                'class' => 'btn btn-default'
            ])?>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">

         <div class="well well-sm">
             <strong>คำแนะนำ</strong>
             <ul>
                 <li>เลือกโครงการก่อนเลือกแบบสอบถามเสมอ</li>
                 <li>ถ้าเป็นแบบสอบถามประเภท Q1(ลูกค้าเยี่ยมชมโครงการ)   พนักงานขายควรบันทึกข้อมูลลงระบบภายในวันที่ลูกคามาเยี่ยมชมทันที</li>
                 <li>หลังบันทึกแบบสอบถาม ควรตรวจทานอีกครั้ง</li>
             </ul>

         </div>
<div class="table-responsive">
    <?php
    \yii\widgets\Pjax::begin();
    echo GridView::widget([
        'dataProvider' => $dataProviderSurvey,
        'filterModel' => $searchModelSurvey,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'site_id',
                'filter' => Html::activeDropDownList($searchModelSurvey, 'site_id', $searchModelSurvey->siteItems, [
                    'class' => 'form-control',
                    'prompt' => '--เลือกไซต์งาน/โครงการ--'
                ]),
                'value' => 'site.site_name'
            ],
            'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{do}',
                'buttons' => [
                    'do' => function ($url, $model) {
                        $customerId = Yii::$app->request->get('customerId');
                        $count = $model->countSurveyByCustomer($model->id, $customerId);
                        if ($count == 0) {
                            $doUrl =  \yii\helpers\Url::to(['survey/do', 'id' => $model->id, 'customer_id' => $customerId]);
                            return Html::a('<span class="fa fa-plus"></span> ', $doUrl, [
                                'title' => Yii::t('app', 'กรอกแบบสอบถามนี้'),
                                'class' => 'btn btn-success btn-xs',
                            ]);
                        } else {
                            return 'มีแล้วในระบบ';
                        }
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    $customerId = Yii::$app->request->get('customerId');
                    $url = \yii\helpers\Url::to(['survey/do', 'id' => $model->id, 'customer_id' => $customerId]);
                    return $url;
                }
            ],
        ],

    ]);
    \yii\widgets\Pjax::end();
    ?>
</div>


    </div><!-- /.box-body -->
</div><!-- /.box -->



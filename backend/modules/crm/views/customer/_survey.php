<?php
use yii\helpers\Html;
use yii\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\crm\models\ResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'เลือกแบบสอบถาม - Choose Questionnaire';
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  $modelCustomer->fullname, 'url' => ['view','id'=>$modelCustomer->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
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
                        return Html::a('<span class="fa fa-plus"></span> ', $url, [
                            'title' => Yii::t('app', 'กรอกแบบสอบถามนี้'),
                            'class' => 'btn btn-success btn-xs',
                        ]);
                    }
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'do') {
                        $customerId = Yii::$app->request->get('customerId');
                        $url = \yii\helpers\Url::to(['survey/do', 'id' => $model->id, 'customer_id' => $customerId]);
                        return $url;
                    }
                }
            ],
        ],

    ]);
    \yii\widgets\Pjax::end();
    ?>
</div>


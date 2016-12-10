<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\crm\models\ResponseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>

<p>
<?php  Html::a('<i class="fa fa-plus"></i> เพิ่มแบบสอบถามใหม่', ['survey','customerId'=>$modelCustomer->id], [
    'class' => 'btn btn-success btn-sm modal-add-questionnaire',
    'title' => 'เพิ่มแบบสอบถาม',
    'data-header' => 'เลือกแบบสอบถาม ที่ต้องการกรอก',
]) ?>
</p>
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
                        $customerId = Yii::$app->request->get('id');
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


<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgCompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'บริษัท';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-company-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('เพิ่มบริษัท', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'code',
                'width' => '80px',
            ],
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' =>function($data){
                    return Html::a($data->name,['division','company_id'=>$data->id]);
                }
            ],
            [
                'header' => 'จำนวนไซต์งาน',
                'value' => function($model){
                    return $model->countOrgSite();
                },
            ],
            // 'img',
            // 'created_at',
            // 'created_by',
            'updated_at:datetime',
            // 'updated_by',
            'active:boolean',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {tree}',
                'buttons' => [
                    'tree' => function($url,$model,$key) {
                        return Html::a('<i class="fa fa-tree"></i>',
                            ['node/edit','company_id' => $model->id],
                            ['title' => 'จัดการแผนผังองค์']

                        );
                    }
                ]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

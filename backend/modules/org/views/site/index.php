<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgSiteSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ไซต์งาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-site-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('สร้างไซต์งาน', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'site_type',
            'site_name',
            [
                'attribute' => 'company.name',
                'filter' => function($model){
                    return $model->arrayCompany;
                }
            ],
            'created_at:datetime',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            'active:boolean',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

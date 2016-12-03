<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\org\models\OrgPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ตำแหน่งงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-position-index">


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('สร้างตำแหน่งงาน', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           // 'id',
           // 'parent.name_th',
            'name_th',
              'levelName',
            'active:boolean',
            // 'type',
            // 'salary',
            // 'create_at',
           /*  [
             'attribute'=>'active',
             'header'=>'Status',
             'filter' => ['Y'=>'Active', 'N'=>'Deactive'],
             'format'=>'raw',
             'value' => function($model, $key, $index)
             {
             	if($model->active == '1')
             	{
             		return 'ใช้งาน';
             	}
             	else
             	{
             		return 'ไม่ใช่งาน';
             	}
             },
             ],*/
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

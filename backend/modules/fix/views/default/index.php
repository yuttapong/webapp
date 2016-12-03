
<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ListMessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ข้อความ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-message-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
           // 'module_id',
            //'table_name',
            //'table_key',
            // 'table_key2',
            [
            'attribute' => 'document_id',
            'label' => 'รายการ',
            'format' => 'raw',
            'value'=> function($data) {
            	return $data->documents->name;
            
            }],
            [
            'attribute' => 'titie',
            'label' => 'รายการ',
            'format' => 'raw',
            'value'=> function($data) {
            	return $data->titie;
            
            }],
            [
            'attribute' => 'description',
            'label' => 'รายละเอียด',
            'format' => 'raw',
            'value'=> function($data) {
            	return $data->description;
            
            }],
            [
            'attribute' => 'link',
            'label' => 'ดู',
            'format' => 'raw',
            'value'=> function($data) {
           $link= Html::a('<span class="glyphicon glyphicon glyphicon-list-alt"></span>', $data->link );
            	return $link;
            
            }],
            // 'option:ntext',
            // 'user_id',
            // 'user_apprever_id',
            // 'user_apprever_name',
            // 'link:ntext',

             [
             'class'=>'kartik\grid\BooleanColumn',
             'attribute'=>'app_status',
             'vAlign'=>'middle',
             ],
            // 'status',
            // 'seq',
            // 'company_id',
            // 'site_id',
            // 'color_code',
            // 'type',
        ],
    ]); ?>
</div>
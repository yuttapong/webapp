<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\UrlRule;

//echo Yii::app()->createUrl("news/view",array("id"=>1 ) );
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\qtn\Models\QtnQuestionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Qtn Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtn-question-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Qtn Question', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'survey_id',
          //  'survey_tab_id',
          //  'survey_title_id',
            'name',
            // 'type_id',
            // 'result_id',
            // 'length',
            // 'precise',
            // 'position',
            // 'content:ntext',
            // 'required',
            // 'deleted',
            // 'public',
            // 'log_status',
            // 'created_at',
            // 'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>

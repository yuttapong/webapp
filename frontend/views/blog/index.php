<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BlogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'บทความ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="blog-index">
    <h1><i class="fa fa-book"></i> <?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php  GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'title',
            //'content:ntext',
            //'category',
            //'tag',
            'created_at:dateTime',

        ],
    ]); ?>


    <?php
    Pjax::begin();
    foreach ($articles as $article){
         echo Html::tag('p',Html::a( '<i class="fa  fa-circle fa-motorcycle fa-2x"></i>  '. $article->title,['blog/view','id'=>$article->id]));
    }
   // echo Html::tag('p', $pagination->totalCount.' รายการ');
    echo LinkPager::widget([
        'pagination' => $pagination,
    ]);
     Pjax::end();
    ?>
</div>

<?php

?>

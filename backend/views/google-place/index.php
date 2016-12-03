<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\GooglePlacesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Google Places';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="google-places-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Add Place', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Add Current Location', ['create_geo'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Add a Google Place', ['create_place_google'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'placeTypeName',
            'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\Marker;

/* @var $this yii\web\View */
/* @var $model backend\models\GooglePlaces */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Google Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="google-places-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'placeTypeName',
            'created_at:dateTime',
            'created_by',
            'updated_at:dateTime',
            'updated_by',
        ],
    ]) ?>

</div>

<div class="col-md-6">
    <div class="place-view">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'placeTypeName',
                'website',
                'full_address',
            ],
        ]) ?>

    </div>
</div> <!-- end first col -->
<div class="col-md-6">
    <?php
    if ($gps) {
        $coord = new LatLng(['lat' => $gps->lat, 'lng' => $gps->lng]);
        $map = new Map([
            'center' => $coord,
            'zoom' => 18,
            'width'=>'350',
            'height'=>'350',
        ]);
        $image = 'https://cdn1.iconfinder.com/data/icons/medical-colored-icons-vol-2/128/047-128.png';
        $marker = new Marker([
            'position' => $coord,
            'title' => $model->name,
            'icon' => $image,
            'opacity' => 0.5,
        ]);
        $map->addOverlay($marker);

        $infoWindow = '';
        echo $map->display();
    } else {
        echo 'ไม่มีแผนที่.';
    }
    ?>
</div> <!-- end second col -->


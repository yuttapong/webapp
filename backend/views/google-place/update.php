<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\GooglePlaces */

$this->title = 'Update Google Places: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Google Places', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="google-places-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

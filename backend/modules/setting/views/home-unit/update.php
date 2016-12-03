<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\home */

$this->title = 'Unit ID : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Homes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="home-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */

$this->title =  $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inventory-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelPrice' => $modelPrice,
    ]) ?>

</div>

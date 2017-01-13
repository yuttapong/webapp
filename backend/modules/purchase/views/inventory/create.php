<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\Models\Inventory */

$this->title = 'เพิ่มสินค้าใหม่';
$this->params['breadcrumbs'][] = ['label' => 'Inventories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inventory-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelPrice' => $modelPrice,
    ]) ?>

</div>

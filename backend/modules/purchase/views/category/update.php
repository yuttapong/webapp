<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\models\Categories */

$this->title = Yii::t('purchase.category', 'Update {modelClass}: ', [
    'modelClass' => 'Categories',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('purchase.category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('purchase.category', 'Update');
?>
<div class="categories-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

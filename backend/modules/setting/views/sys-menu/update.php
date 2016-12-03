<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SysMenu */

$this->title = 'Update Sys Menu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sys Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-menu-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SysModule */

$this->title = 'Update Module: ' . $model->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => 'โมดูล', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Module:: ' . $model->name_th, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-module-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelsMenu' => $modelsMenu,
    ]) ?>

</div>

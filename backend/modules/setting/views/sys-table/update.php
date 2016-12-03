<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SysTable */

$this->title = Yii::t('app', 'แก้ไข {modelClass}: ', [
    'modelClass' => 'ชุดข้อมูล',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'ชุดข้อมูล'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="sys-table-update">
    <?= $this->render('_form', [
        'model' => $model,
        'modelsItem' => $modelsItem,
    ]) ?>

</div>

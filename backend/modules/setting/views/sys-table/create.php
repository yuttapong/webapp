<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SysTable */

$this->title = Yii::t('app', 'สร้างชุดข้อมูล');
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sys Tables'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsItem' => $modelsItem
    ]) ?>

</div>

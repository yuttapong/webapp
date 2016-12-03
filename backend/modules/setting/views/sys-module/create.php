<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SysModule */

$this->title = 'Create Module';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => 'โมดูล', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-module-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsMenu' => $modelsMenu
    ]) ?>

</div>

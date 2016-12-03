<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\orgDivision */

$this->title = 'แก้ไขฝ่าย: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'ฝ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-division-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

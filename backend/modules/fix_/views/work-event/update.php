<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */

$this->title = 'แก้ไขตารางงาน : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Work Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="work-event-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

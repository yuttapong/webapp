<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\WorkEvent */

$this->title = 'New Event - เพิ่มตารางงาน';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="work-event-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

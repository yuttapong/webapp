<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\orgDepartment */

$this->title = 'แก้ไขแผนก: ' . $model->name;

$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->orgPart->orgDivision->name,
    'url' => ['parts', 'division_id' => $model->orgPart->orgDivision->id]
];

$this->params['breadcrumbs'][] = [
    'label' => $model->orgPart->name,
    'url' => ['departments', 'part_id' => $model->part_id]
];

$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['department', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-department-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\orgPart */

$this->title = 'แก้ไขส่วนงาน: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
$this->params['breadcrumbs'][] = [
    'label' => $model->orgDivision->name,
    'url' => ['part/index','division_id'=>$model->orgDivision->id]
];

$this->params['breadcrumbs'][] = ['label' => 'ส่วนงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-part-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\orgDepartment */

$this->title = 'สร้างแผนก';
$this->params['breadcrumbs'][] = [
    'label' => 'ฝ่าย',
    'url' => ['division/index']
];
if (Yii::$app->request->get('part_id')) {

    $this->params['breadcrumbs'][] = [
        'label' => $modelPart->orgDivision->name,
        'url' => ['parts','division_id'=>$modelPart->orgDivision->id]
    ];
    $this->params['breadcrumbs'][] = [
        'label' => $model->orgPart->name,
        'url' => ['departments','part_id'=> $model->part_id]
    ];
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-department-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelpart' => $modelPart,
    ]) ?>

</div>

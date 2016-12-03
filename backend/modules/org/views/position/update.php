<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPosition */

$this->title = 'แก้ไข: ' . $model->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name_th, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-position-update">


    <?= $this->render('_form', [
        'model' => $model,
        'modelsProp' => $modelsProp,
        'modelsRes' => $modelsRes,
    ]) ?>

</div>

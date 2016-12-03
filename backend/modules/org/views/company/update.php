<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgCompany */

$this->title = 'แก้ไข: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'บริษัท', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="org-company-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SysDocument */

$this->title = 'Update Sys Document: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sys Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->document_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sys-document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

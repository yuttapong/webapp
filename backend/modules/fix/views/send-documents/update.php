<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\SendDocuments */

$this->title = 'Update Send Documents: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Send Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="send-documents-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

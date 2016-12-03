<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\ListApprever */

$this->title = 'Update List Apprever: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'List Apprevers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="list-apprever-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	'inform_fix_id' => $inform_fix_id,
    ]) ?>

</div>

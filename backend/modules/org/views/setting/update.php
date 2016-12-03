<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgJobOption */

$this->title = 'Update Org Job Option: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Org Job Option', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="org-job-option-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

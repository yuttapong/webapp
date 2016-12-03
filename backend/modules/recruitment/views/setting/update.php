<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmSetting $model
 */

$this->title = 'Update Rcm Setting: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rcm Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rcm-setting-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

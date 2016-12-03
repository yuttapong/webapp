<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmSetting $model
 */

$this->title = 'Create Rcm Setting';
$this->params['breadcrumbs'][] = ['label' => 'Rcm Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rcm-setting-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

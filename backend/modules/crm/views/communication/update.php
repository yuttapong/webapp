<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Communication $model
 */

$this->title = Yii::t('crm.communication', 'Update {modelClass}: ', [
    'modelClass' => 'Communication',
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm.communication', 'Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('crm.communication', 'Update');
?>
<div class="communication-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

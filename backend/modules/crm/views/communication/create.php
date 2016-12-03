<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Communication $model
 */

$this->title = Yii::t('crm.communication', 'สร้าง {modelClass}', [
    'modelClass' => 'การติดต่อสื่อสารกับลูกค้า',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('crm.communication', 'Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="communication-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

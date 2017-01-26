<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SysDocument */

$this->title = 'Create Sys Document';
$this->params['breadcrumbs'][] = ['label' => 'Sys Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

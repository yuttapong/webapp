<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SysTambon */

$this->title = 'Create Sys Tambon';
$this->params['breadcrumbs'][] = ['label' => 'Sys Tambons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-tambon-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

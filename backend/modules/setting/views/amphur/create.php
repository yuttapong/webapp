<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SysAmphur */

$this->title = 'Create Sys Amphur';
$this->params['breadcrumbs'][] = ['label' => 'Sys Amphurs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-amphur-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

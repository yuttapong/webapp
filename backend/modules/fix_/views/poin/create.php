<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\Poin */

$this->title = 'Create Poin';
$this->params['breadcrumbs'][] = ['label' => 'Poins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="poin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

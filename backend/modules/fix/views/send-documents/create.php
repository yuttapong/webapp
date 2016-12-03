<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\SendDocuments */

$this->title = 'Create Send Documents';
$this->params['breadcrumbs'][] = ['label' => 'Send Documents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="send-documents-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

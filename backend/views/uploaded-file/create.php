<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UploadedFile */

$this->title = 'Create Uploaded File';
$this->params['breadcrumbs'][] = ['label' => 'Uploaded Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploaded-file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

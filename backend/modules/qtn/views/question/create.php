<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\Models\QtnQuestion */

$this->title = 'Create Qtn Question';
$this->params['breadcrumbs'][] = ['label' => 'Qtn Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qtn-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

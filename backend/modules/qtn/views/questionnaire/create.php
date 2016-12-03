<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\qtn\models\Questionnaire */

$this->title = 'Create Questionnaire';
$this->params['breadcrumbs'][] = ['label' => 'Questionnaires', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="questionnaire-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

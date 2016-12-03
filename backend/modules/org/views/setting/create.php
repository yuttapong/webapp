<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgJobOption */

$this->title = 'Create Org Job Option';
$this->params['breadcrumbs'][] = ['label' => 'Org Job Option', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-job-option-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

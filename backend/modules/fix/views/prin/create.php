<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\Prin */

$this->title = 'Create Prin';
$this->params['breadcrumbs'][] = ['label' => 'Prins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
//$this->registerJsFile('@web/js/fix/prin.js');
?>
<div class="prin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    		'modelInven' => $modelInven,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\purchase\models\Categories */

$this->title = Yii::t('purchase.category', 'Create Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('purchase.category', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

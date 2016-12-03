<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SysGeoGraphy */

$this->title = 'สร้างภาค';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า', 'url' => ['/setting/']];
$this->params['breadcrumbs'][] = ['label' => 'ภาค', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-geo-graphy-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

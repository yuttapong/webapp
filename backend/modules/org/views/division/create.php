<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\orgDivision */

$this->title = 'สร้างฝ่าย';
$this->params['breadcrumbs'][] = ['label' => 'ฝ่าย', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-division-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

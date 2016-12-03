<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SysMenu */

$this->title = 'สร้างเมนู';
$this->params['breadcrumbs'][] = ['label' => 'เมนู', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-menu-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

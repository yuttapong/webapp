<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\SysBasicData */

$this->title = Yii::t('app', 'เพิ่มข้อมูล::');
$this->params['breadcrumbs'][] = ['label' => 'ชุดข้อมูลพื้นฐาน', 'url' => ['sys-table/index']];
/*
$this->params['breadcrumbs'][] = [
    'label' => Yii::t('app', $group->name),
    'url' => ['index','SysBasicDataSearch[table_id]'=>$group->_id]
];
*/
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sys-basic-data-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

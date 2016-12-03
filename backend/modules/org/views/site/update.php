<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\OrgSite */

$this->title = 'แก้ไข: ' . $model->site_name;
$this->params['breadcrumbs'][] = ['label' => 'ไซต์งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->site_name, 'url' => ['view', 'id' => $model->site_id]];
$this->params['breadcrumbs'][] = 'แก้ไข';
?>
<div class="org-site-update">



    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

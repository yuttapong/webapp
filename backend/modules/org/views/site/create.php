<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrgSite */

$this->title = 'สร้างไซต์งาน';
$this->params['breadcrumbs'][] = ['label' => 'ไซต์งาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-site-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

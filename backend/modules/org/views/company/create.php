<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgCompany */

$this->title = 'เพิ่มบริษัท';
$this->params['breadcrumbs'][] = ['label' => 'บริษัท', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-company-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

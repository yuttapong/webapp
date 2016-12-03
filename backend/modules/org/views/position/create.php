<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPosition */

$this->title = 'สร้างตำแหน่งงาน';
$this->params['breadcrumbs'][] = ['label' => 'ตำแหน่งงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="org-position-create">


    <?= $this->render('_form', [
        'model' => $model,
    		'modelsProp' => $modelsProp,
    		'modelsRes' => $modelsRes,
    ]) ?>

</div>

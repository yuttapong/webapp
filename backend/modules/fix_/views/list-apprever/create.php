<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\fix\Models\ListApprover */

$this->title = 'Create List Apprever';
$this->params['breadcrumbs'][] = ['label' => 'List Apprevers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="list-apprever-create">

    <?= $this->render('_form', [
        'model' => $model,
    		'listApprove' =>$listApprove,
        			'inform_fix_id' => $inform_fix_id,
        			'modelFix' => $modelFix,
    ]) ?>

</div>

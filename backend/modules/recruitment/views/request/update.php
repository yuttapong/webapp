<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\modules\recruitment\models\RcmAppManpower $model
 */

$this->title =  $model->code.' : '. @$model->position->name_th;
$this->params['breadcrumbs'][] = ['label' => 'ขออัตรากำลังคน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

?>
<div class="rc-app-manpower-update">



 <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

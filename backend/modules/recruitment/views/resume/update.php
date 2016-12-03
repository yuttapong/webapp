<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\RcmAppForm */


$this->title = $modelPersonnel->fullnameTH;
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ใบสมัครงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->code .' :: ' . $this->title;


?>
<div class="rcm-app-form-update">
    <?= $this->render('_form-apply', [
        'model' => $model,
        'modelPersonnel' => $modelPersonnel,
        'modelsEducation' => $modelsEducation,
        'modelsWork' => $modelsWork,
        'citizenAmphur' => $citizenAmphur,
        'citizenAmphur' => $citizenAmphur,
    ]) ?>

</div>

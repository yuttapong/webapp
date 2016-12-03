<?php

$this->title = $modelPersonnel->fullnameTH;
$this->params['breadcrumbs'][] = 'ระบบรับสมัครงาน';
$this->params['breadcrumbs'][] = ['label' => 'ใบสมัครงาน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>

<?=$this->render('_form', [
    'model' => $model,
    'modelPersonnel' => $modelPersonnel,
]) ?>

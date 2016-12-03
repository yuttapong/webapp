<?php
/* @var $this yii\web\View */
?>
<h1>cronjob/index</h1>
<?php
foreach ($models as $model){
    echo'<br>' . $model->EMPID .' ' . $model->EMPFNAME.' '.$model->EMPLNAME;
}
?>

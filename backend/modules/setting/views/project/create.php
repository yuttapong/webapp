<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\project */

$this->title = 'Create Project';
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$this->title?></h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->


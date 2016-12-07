<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */

$this->title = Yii::t('setting.role', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('setting.role', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">New User</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    <?= $this->render('_signup', [
        'model' => $model,
        'userModule' => $userModule,
        'modules' => $modules,
        'moduleItems' => $moduleItems,
        'itemsAssigned' => $itemsAssigned,
        'itemsAllRole' => $itemsAllRole,
    ]) ?>

    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- box-footer -->
</div><!-- /.box -->

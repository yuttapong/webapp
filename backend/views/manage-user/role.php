<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
use common\models\AuthRight;
use common\models\SysModule;
use yii\bootstrap\Tabs;
use kartik\tabs\TabsX;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = Yii::t('app', 'กำหนดสิทธิ์ใช้งาน {modelClass}', [
        'modelClass' => 'User',
    ]) . ' ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'กำหนดสิทธิ์');
?>
<div class="user-update">

    <h1><?php //= Html::encode($this->title) ?></h1>

    <?php


    /* @var $this yii\web\View */
    /* @var $model common\models\User */
    /* @var $form yii\widgets\ActiveForm */
    ?>
    <p>
        <label>Username :</label> <?= $model->username ?> &nbsp;
        <label>Email :</label> <?= $model->email ?>
    </p>
<style>

</style>

    <div class="user-form">

        <?php $form = ActiveForm::begin(); ?>



        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<style>

</style>

    <?php

    // Left
    echo TabsX::widget([
        'items' => $itemsTab,
        'position' => TabsX::POS_ABOVE,
        'encodeLabels' => false,
        'bordered'=>true,
    ]);

    ?>

</div>


<script>
    function loadright(el) {
        var v = el.value;
        var target = $("#rights");
        $.get("manage-user/load-right", {module_id: v}, function (rs) {
            target.html(rs);
        })

    }
</script>

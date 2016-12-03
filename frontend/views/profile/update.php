<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'แก้ไขโปรไฟล์';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update Profile');
?>

<div class="user-update">
    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

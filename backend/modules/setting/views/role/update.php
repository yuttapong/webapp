<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */

$this->title = Yii::t('setting.role', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]) . $model->username;


$this->params['breadcrumbs'][] = ['label' => Yii::t('setting.role', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('setting.role', 'Update');
?>
<div class="user-update">
    <h1><?= Html::encode(@$model->personnel->fullnameTH).' ('.$model->username.')'; ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
        'userModule' => $userModule,
        'modules' => $modules,
        'moduleItems' => $moduleItems,
        'roles' => $roles,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */

$this->title = Yii::t('setting.role', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Yii::t('setting.role', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'userModule' => $userModule,
        'modules' => $modules,
        'moduleItems' => $moduleItems,
        'roles' => $roles,
    ]) ?>

</div>

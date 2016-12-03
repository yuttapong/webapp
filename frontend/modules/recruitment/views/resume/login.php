<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RcmAppForm */
/* @var $form ActiveForm */

$this->title = 'เข้าสู่ระบบ';
$this->params['breadcrumbs'][] = ['label' => 'ระบบรับสมัครงาน', 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <?php $form = ActiveForm::begin([]); ?>
  <p>
  <?=$form->errorSummary($model)?>
<div class="col-xs 12 col-md-5">
    <?= $form->field($model, 'username')->textInput(); ?>
    <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('เข้าสู่ระบบ', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

  </p>

    <?php ActiveForm::end(); ?>


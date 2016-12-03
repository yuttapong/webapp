<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'กู้รหัสผ่าน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset col-sm-6">
    <p>กรุณากรอกอีเมลของคุณ ระบบจะส่งลิ้งสำหรับตั้งรหัสผ่านใหม่ไปยังอีเมล์.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email') ?>

                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

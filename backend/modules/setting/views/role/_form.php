<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>
<?php echo $form->errorSummary($model);?>

<div class="user-form">
    <div class="form-group" align="right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('setting.role', 'Create') : Yii::t('setting.role', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-6">
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->radioList(\common\models\User::getitemStatus()) ?>
    <?= $form->field($model, 'banned_reason')->textarea()?>
    <?php $form->field($model, 'role_id')->dropDownList($roles)?>

</div>

<div class="col-xs-12 col-sm-6 col-md-6">
    <?php
    foreach ($modules as $module){
        $mark =   false;
        if( in_array($module->id, $userModule)){
            $mark = true;
        }
        $checkbox =  Html::checkbox('module[]', $mark,['value' => $module->id]) . '  '.$module->name_th;
        echo Html::tag('p',$checkbox);
    }
    ?>

</div>

</div>
<?php ActiveForm::end(); ?>
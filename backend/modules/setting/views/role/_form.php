<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\setting\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></i>';
?>

<?php $form = ActiveForm::begin(); ?>
<?php echo $form->errorSummary($model);?>

 <div class="row">


    <div class="col-xs-12 col-sm-6 col-md-6">
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::getitemStatus(),['prompt'=>'-Select-']) ?>
    <?= $form->field($model, 'banned_reason')->textarea()?>
    <?= $form->field($model, 'roles')->checkboxList($itemsAllRole,['prompt' => '--Select--'])?>

</div>

<div class="col-xs-12 col-sm-6 col-md-6">
    <?= $form->field($model, 'modules')->checkboxList(\yii\helpers\ArrayHelper::map($modules,'id','name_th'),['prompt' => '--Select--'])?>

</div>

 </div>

    <div class="form-group" align="">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('setting.role', 'Create') : Yii::t('setting.role', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>




<?php ActiveForm::end(); ?>
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
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::getitemStatus(),['prompt'=>'-Select-']) ?>
    <?= $form->field($model, 'roles')->checkboxList($itemsAllRole,['prompt' => '--Select--'])?>

</div>

<div class="col-xs-12 col-sm-6 col-md-6">
    <?= $form->field($model, 'modules')->checkboxList(\yii\helpers\ArrayHelper::map($modules,'id','name_th'),['prompt' => '--Select--'])?>

            <?php
             /*
            foreach ($modules as $module){
                $mark =   false;
                if( in_array($module->id, $userModule)){
                    $mark = true;
                }
                $checkbox =  Html::checkbox('module[]', $mark,['value' => $module->id]) . '  '.$module->name_th;
                echo Html::tag('p',$checkbox);
            }
             */
            ?>

</div>

        </div>


    <div class="form-group" align="right">
        <?= Html::submitButton( Yii::t('setting.role', 'Create'), ['class' =>'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>
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

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">สามารถเห็น icon ระบบงานดังต่อไปนี้</h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body">

 <div class="row">
    <div class="form-group" align="right">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('setting.role', 'Create') : Yii::t('setting.role', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6">
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
    <?= $form->field($model, 'status')->dropDownList(\common\models\User::getitemStatus(),['prompt'=>'-Select-']) ?>
    <?= $form->field($model, 'banned_reason')->textarea()?>
    <?= $form->field($model, 'roles')->checkboxList($itemsAllRole,['prompt' => '--Select--'
    ])?>

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



        </div><!-- /.box-body -->
        <div class="box-footer">






        </div><!-- box-footer -->
    </div><!-- /.box -->



<?php ActiveForm::end(); ?>
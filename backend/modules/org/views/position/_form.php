<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\org\models\OrgDivision;
use yii\jui\JuiAsset;
use backend\modules\org\RequestAsset;

/* @var $this yii\web\View */
/* @var $model backend\modules\org\models\OrgPosition */
/* @var $form yii\widgets\ActiveForm */
RequestAsset::register($this);
?>
    <div class="org-position-form">

        <?php $form = ActiveForm::begin([
            'id' => 'position-form',
        ]); ?>
        <?= $form->errorSummary($model) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>



        <div class="row">

            <div class="col-xs-12 col-sm-6 col-md-6">

                <?= $form->field($model, 'name_th')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>

                <!-- ฝ่าย/ส่วน/แผนก -->
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= $form->field($model, 'division_id')
                            ->dropDownList(OrgDivision::getDivisionList(), ['prompt' => '-Select-']) ?>
                        <?= $form->field($model, 'part_id')
                            ->dropDownList(\backend\modules\org\models\OrgPart::getPartList(), ['prompt' => '-Select-']) ?>
                        <?= $form->field($model, 'department_id')
                            ->dropDownList(\backend\modules\org\models\OrgDepartment::getDepartmentList(),
                                ['prompt' => '-Select-']
                            ) ?>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-6">

                <?= $form->field($model, 'level')->dropDownList($model->getLevelItems(),
                    ['prompt' => '']) ?>

                <?= $form->field($model, 'active')->widget(\kartik\widgets\SwitchInput::className()) ?>
            </div>


            <div class="col-xs-12 col-sm-6 col-md-6">
                <?php
                echo '<h5>คุณสมบัติผู้สมัคร</h5>';
                echo $this->render("_items-property", [
                    'modelsProp' => $modelsProp,
                    'form' => $form,
                ]);
                echo '<h5>ความรับผิดชอบ</h5>';
                echo $this->render("_items-responsibility", [
                    'modelsRes' => $modelsRes,
                    'form' => $form,
                ]);

                ?>
            </div>

        </div>

        <?php ActiveForm::end(); ?>
    </div>
<?php
JuiAsset::register($this);

<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use common\siricenter\thaiformatter\ThaiDate;

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Customer $model
 * @var yii\widgets\ActiveForm $form
 */


\backend\modules\crm\CustomerAsset::register($this);
?>




    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL,
        'id' => 'customer-form',
        'enableAjaxValidation' => true,
    ]);
?>

    <div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-circle fa-2x"></i> ข้อมูลทั่วไป</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <?php
            echo Html::tag('p',
                Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'บันทึกข้อมูล'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']),
                ['align' => 'center']);

            ?>

        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 4,
        'attributes' => [
            'gender' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items' => $model->getGenderItems(),
                'options' => ['prompt' => '-เพศ-']
            ],
            'prefixname' => ['type' => Form::INPUT_DROPDOWN_LIST,'items'=>$model->getPrefixNameItems(),'options'=> [
                'prompt' => '-คำนำหน้า-'
            ]],
            'prefixname_other' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'คำนำหน้าพิเศษ...']],

            'firstname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ ชื่อจริง...']],
            'lastname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ นามสกุล...']],

            'age' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ อายุ...']],
           // 'birthday' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATE]],
            'birthday' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \yii\widgets\MaskedInput::className(),
                'options' => [

                    'clientOptions' => [
                        'alias' => ['99-99-9999']
                    ]
                ],
            ],
            'tel' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ เบอร์โทร...']],
            'mobile' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => \yii\widgets\MaskedInput::className(),
                'options' => [
                    'clientOptions' => [
                        'alias' => ['9999999999']
                    ]
                ],
            ],

            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'ระบุ Email...']],
            'source' => [
                'type' => Form::INPUT_DROPDOWN_LIST,
                'items'=>$model->getSourceItems(),
                'options'=> [
                    'prompt' => '-แหล่งที่มา-'
                ]
            ],
            'is_vip' => ['type' => Form::INPUT_CHECKBOX, 'options' => ['title' => 'เป็นลูกค้า VIP']],

        ]

    ]);
?>


        <?=Html::activeLabel($model,'createdName')?> : <?=$model->getCreatedName()?> (<?=ThaiDate::widget([
        'timestamp' => $model->created_at,
        'showTime' => true,
        ])?>)
<br>
        <?=Html::activeLabel($model,'updatedName')?> : <?=$model->getUpdatedName()?> (<?=ThaiDate::widget([
            'timestamp' => $model->updated_at,
            'showTime' => true,
        ])?>)

</div><!-- /.box-body -->
<div class="box-footer">

</div><!-- box-footer -->
</div><!-- /.box -->





    <?php
    if($model->isNewRecord){
        echo '<br>';
        /**
         * ที่อยุ่ที่สามาติดต่อได้
         */
        echo  $this->render('address/_form-type-contact',[
            'modelCustomer' => $model,
            'form' => $form,
            'modelAddress'=>$modelAddressContact,
        ]);
        echo '<br>';
        /**
         * ที่อยุ่ที่ทำงาน
         */
        echo  $this->render('address/_form-type-office',[
            'modelCustomer' => $model,
            'form' => $form,
            'modelAddress'=>$modelAddressOffice,
        ]);
    }

?>



    <?php
    ActiveForm::end();


    ?>


<?php
//แสดงปุ่มเพิ่มที่อยุู่ในหน้าแก้ไข
if ( ! $model->isNewRecord) {
?>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <?php

            echo $this->render('address/index',[
                'modelCustomer' => $model,
                'dataProviderAddress'=>$dataProviderAddress
            ]);
            ?>
        </div>

        <div class="col-xs-12 col-sm-6">
            <?php
            echo $this->render('person-in-charge/index',[
                'modelCustomer' => $model,
                'dataProviderPersonInCharge'=>$dataProviderPersonInCharge
            ]);
            ?>
        </div>
    </div>



<?php
    Modal::begin([
      'closeButton' => [
        'label' => 'Close',
        'class' => 'btn btn-danger btn-sm pull-right',
     ],
     'size' => 'modal-lg',
      //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
        'header' => '<h2></h2>',
        'id' => 'modal-customer'
    ]);
    Modal::end();

    Modal::begin([
      'closeButton' => [
        'label' => 'Close',
        'class' => 'btn btn-danger btn-sm pull-right',
     ],
     'size' => 'modal-sm',
     // 'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
        'header' => '<h2></h2>',
        'id' => 'modal-personincharge'
    ]);
    Modal::end();


}


?>





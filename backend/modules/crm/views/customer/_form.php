<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use common\siricenter\thaiformatter\ThaiDate;
use yii\bootstrap\Collapse;
/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Customer $model
 * @var yii\widgets\ActiveForm $form
 */

\backend\modules\crm\CustomerAsset::register($this);
use yii\bootstrap\Tabs;
?>


    <?php $form = ActiveForm::begin([
        'type'=>ActiveForm::TYPE_VERTICAL,
        'id' => 'customer-form',
        'enableAjaxValidation' => true,
    ]);
?>

    <div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-user-circle fa-2x"></i> ข้อมูลทั่วไป - General</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <?php
            echo
                Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'บันทึกข้อมูล'), [
                    'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'
                ]);
            ?>
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">
    <?php
  /// $this->render('customer/_form-general',['model' => $model,'form'=>$form]);
?>

<?php if( ! $model->isNewRecord):?>
        <?=Html::activeLabel($model,'createdName')?> : <?=$model->getCreatedName()?> (<?=ThaiDate::widget([
        'timestamp' => $model->created_at,
        'showTime' => true,
        ])?>)
        <?=Html::activeLabel($model,'updatedName')?> : <?=$model->getUpdatedName()?> (<?=ThaiDate::widget([
            'timestamp' => $model->updated_at,
            'showTime' => true,
        ])?>)
  <?php endif;?>


</div><!-- /.box-body -->
<div class="box-footer">

</div><!-- box-footer -->
</div><!-- /.box -->


<?php
echo Tabs::widget([
    'encodeLabels' => false,
    'items' => [
        // equivalent to the above
        [
            'label' => '<i class="fa fa-user-circle fa-2x"></i> ข้อมูลทั่วไป - General',
            'content' =>'<p>'.$this->render('customer/_form-general',['model' => $model,'form'=>$form]).'</p>',
            // open its content by default
        ],
        // another group item
        [
            'label' => '<i class="fa fa-address-card fa-2x"></i> ที่อยู่ - Address',
            'content' => '<p>' . $this->render($model->isNewRecord?'address/create':'address/update',[
                'modelCustomer' => $model,
                'form' => $form,
                'modelAddressContact'=>isset($modelAddressContact)?$modelAddressContact:null,
                'modelAddressOffice'=> isset($modelAddressOffice)?$modelAddressOffice:null,
                'dataProviderAddress'=>$dataProviderAddress
            ]).'</p>',
            'visible'=>true,
        ],
        [
            'label' => '<i class="fa fa-address-card fa-2x"></i> ผู้รับผิดชอบ - Person In Charge',
            'content' => '<p>' . $this->render($model->isNewRecord?'person-in-charge/index':'person-in-charge/index',[
                    'modelCustomer' => $model,
                    'form' => $form,
                    'dataProviderPersonInCharge'=>$dataProviderPersonInCharge
                ]).'</p>',
            'visible'=>$model->isNewRecord?false:true,
        ],
    ]
]);

?>



    <?php

//    if($model->isNewRecord){
//        echo '<br>';
//        /**
//         * ที่อยุ่ที่สามาติดต่อได้
//         */
//        echo  $this->render('address/_form-type-contact',[
//            'modelCustomer' => $model,
//            'form' => $form,
//            'modelAddress'=>$modelAddressContact,
//        ]);
//        echo '<br>';
//        /**
//         * ที่อยุ่ที่ทำงาน
//         */
//        echo  $this->render('address/_form-type-office',[
//            'modelCustomer' => $model,
//            'form' => $form,
//            'modelAddress'=>$modelAddressOffice,
//        ]);
//    }


?>
    <?php
    ActiveForm::end();


    ?>


<?php
//แสดงปุ่มเพิ่มที่อยุู่ในหน้าแก้ไข
if ( ! $model->isNewRecord) {
?>

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





<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use \backend\modules\crm\CustomerAsset;

CustomerAsset::register($this);


/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Customer $model
 */


$this->title = $model->firstname . '  ' . $model->lastname;

$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];

$this->params['breadcrumbs'][] = $this->title;

$ccustomerId = $model->id;
?>

<div class="">

    <div class="">

            <?php echo Html::a('<i class="fa fa-plus"></i> เพิ่มที่อยู่',
                ['customer/add-address', 'customerId' => $model->id],
                [
                    'class' => 'btn btn-sm btn-success modal-add-address',
                    'title' => 'เพิ่มที่อยู่ใหม่',
                    'data-header' => 'เพิ่ม: ที่อยู่ใหม่',
                ]);
            ?>
            <?php echo Html::a('<i class="fa fa-plus"></i> เพิ่มแบบสอบถอบ',
                ['survey/do', 'customer_id' => $model->id],
                [
                    'class' => 'btn btn-sm btn-success yn-popup-link',
                    'title' => 'เพิ่มข้อมูลการติดต่อสื่อสารกับลูกค้า',
                    'data-header' => 'เพิ่ม: ข้อมูลการติดต่อสื่อสารกับลูกค้า',
                ]);
            ?>
            <?php echo Html::a('<i class="fa fa-plus"></i> เพิ่มข้อมูลการติดต่อสื่อสารกับลูกค้า',
                ['customer/add-communication', 'customerId' => $model->id],
                [
                    'class' => 'btn btn-sm btn-success modal-add-communication',
                    'title' => 'เพิ่มข้อมูลการติดต่อสื่อสารกับลูกค้า',
                    'data-header' => 'เพิ่ม: ข้อมูลการติดต่อสื่อสารกับลูกค้า',
                ]);
            ?>



        <?php
        if ($model->prefixname) {
            echo Html::tag('div', Html::activeLabel($model, 'prefixname') . ': ' . Html::tag('span', $model->prefixname));
        }
        ?>
        <?php
        if ($model->prefixname_other) {
            echo Html::tag('div', Html::activeLabel($model, 'prefixname_other') . ': ' . Html::tag('span', $model->prefixname_other));
        }
        ?>

        <?php
        if ($model->firstname) {
            echo Html::tag('div', Html::activeLabel($model, 'firstname') . ': ' . Html::tag('span', $model->firstname . ' ' . $model->lastname));
        }
        ?>
        <?php
        if ($model->gender) {
            echo Html::tag('div', Html::activeLabel($model, 'gender') . ': ' . Html::tag('span', $model->genderName));
        }
        ?>

        <?php
        if ($model->birthday) {
            echo Html::tag('div', Html::activeLabel($model, 'birthday') . ': ' . Html::tag('span', $model->birthday));
        }
        ?>

        <?php
        if ($model->mobile) {
            echo Html::tag('div', Html::activeLabel($model, 'mobile') . ': ' . Html::tag('span', $model->mobile));
        }
        ?>
        <?php
        if ($model->tel) {
            echo Html::tag('div', Html::activeLabel($model, 'tel') . ': ' . Html::tag('span', $model->tel));
        }
        ?>
        <?php
        if ($model->age) {
            echo Html::tag('div', Html::activeLabel($model, 'age') . ': ' . Html::tag('span', $model->age));
        }
        ?>
        <?php
        if ($model->email) {
            echo Html::tag('div', Html::activeLabel($model, 'email') . ': ' . Html::tag('span', $model->email));
        }
        ?>
        <?php
        if ($model->is_vip) {
            echo Html::tag('div', Html::activeLabel($model, 'is_vip') . ': ' . Html::tag('span', $model->is_vip));
        }
        ?>
        <?php
        if ($model->source) {
            echo Html::tag('div', Html::activeLabel($model, 'source') . ': ' . Html::tag('span', $model->sourceName));
        }
        ?>
        <?php
        if ($model->currentPersonInCharge) {
            echo Html::tag('div', Html::activeLabel($model, 'source') . ': ' . Html::tag('span', $model->currentPersonInChargeFullname));
        }
        ?>
        <?php
        if ($model->created_by) {

            $timeCreated = \common\siricenter\thaiformatter\ThaiDate::widget([
                'timestamp' => $model->created_at,
                'showTime' => true,
            ]);

            echo html::tag('div', Html::activeLabel($model, 'created_by') . ': ' . Html::tag('span', $model->createdName . " ({$timeCreated})"));
        }
        ?>


        <?php
        if ($model->updated_by) {
            $timeUpdated = Html::tag('span', \common\siricenter\thaiformatter\ThaiDate::widget([
                'timestamp' => $model->updated_at,
                'showTime' => true,
            ]));
            echo Html::tag('div', Html::activeLabel($model, 'updated_by') . ': ' . $model->updatedName . " ({$timeUpdated})");
        }
        ?>

        <?php
        echo Html::a('<i class="fa fa-edit"></i> Edit', ['customer/update', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
        ?>

    </div>
<br>
    <div class="">
        <!-- start communication of customer -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-commenting"></i> Communication -
                    การติดต่อสื่อสาร</h3>

                <div class="box-tools pull-right">
                    <?php
                    // new address
                    if (Yii::$app->user->can('/crm/customer/add-address')) {
                        echo Html::a('<i class="fa fa-plus"></i>',
                            ['customer/add-communication', 'customerId' => $model->id],
                            [
                                'class' => 'btn btn-success btn-sm  modal-add-address',
                                'title' => 'เพิ่มประวัติการติดตามลูกค้า',
                                'data-header' => 'เพิ่ม: ประวัติการติดตามลูกค้า',
                            ]);
                    }
                    ?>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                echo $this->render('communication/index', ['modelCustomer' => $model,
                    'dataProvider' => $dataProviderComm,
                    'searchModel' => $searchComm,
                    'dataProviderResponse' => $dataProviderResponse,
                ]);
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- end communication of customer -->

    <!-- Address-->
    <div class="">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-home"></i> ที่อยู่ลูกค้า</h3>
                <div class="box-tools pull-right">
                    <?php
                    // new address
                    if (Yii::$app->user->can('/crm/customer/add-address')) {
                        echo Html::a('<i class="fa fa-plus"></i>',
                            ['customer/add-address', 'customerId' => $model->id],
                            [
                                'class' => 'btn btn-success btn-sm  modal-add-address',
                                'title' => 'เพิ่มที่อยู่ใหม่',
                                'data-header' => 'เพิ่ม: ที่อยู่ใหม่',
                            ]);
                    }
                    ?>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                echo $this->render('address/index', ['modelCustomer' => $model,
                    'dataProviderAddress' => $dataProviderAddress,]);
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

    </div>
    <!-- end address -->


    <!-- Survey-->
    <div class="">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-list"></i> ประเภทแบบสอบถาม - Questionnaire Type </h3>

                <div class="box-tools pull-right">

                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                echo $this->render('_survey', ['modelCustomer' => $model,
                    'searchModelSurvey' => $searchModelSurvey,
                    'dataProviderSurvey' => $dataProviderSurvey,
                    'customerId' => $model->id,]);
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
  <!--end survey -->



    <div class="">
        <!-- start Questionnaire -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-book"></i> แบบสอบของถามลูกค้า - Questionnaire</h3>

                <div class="box-tools pull-right">

                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php
                echo $this->render('_questionnaire', ['modelCustomer' => $model,
                    'dataProviderAddress' => $dataProviderAddress,
                    'dataProviderResponse' => $dataProviderResponse,
                ]);
                ?>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
<!-- end Questionnaire-->



    </div>


<?php

Modal::begin([
    'id' => 'modal-customer',
    'size' => 'modal-lg',
]);
Modal::end();

Modal::begin([
    'id' => 'modal-communication',
    'size' => 'modal-md',
]);
Modal::end();
?>








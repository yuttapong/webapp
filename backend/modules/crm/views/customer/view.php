<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use \backend\modules\crm\CustomerAsset;
use yii\bootstrap\Tabs;

CustomerAsset::register($this);

/**
 * @var yii\web\View $this
 * @var backend\modules\crm\models\Customer $model
 */


$this->title = $model->firstname . '  ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<p>
    <?php
    if (Yii::$app->user->can('/crm/customer/add-address')) :
        echo Html::a('<i class="fa fa-plus"></i>  เพิ่มที่อยู่ - New Address',
            ['customer/add-address', 'customerId' => $model->id],
            [
                'class' => 'btn btn-sm btn-success modal-add-address',
                'title' => 'เพิ่มที่อยู่ - New Address',
                'data-header' => 'เพิ่ม: ที่อยู่ใหม่',
            ]);
    endif;
    ?>

    <?php
    if (Yii::$app->user->can('/crm/customer/choose-survey')) :
        echo Html::a('<i class="fa fa-plus"></i> เพิ่มแบบสอบถอบ - New Questionnaire',
            ['customer/choose-survey', 'customerId' => $model->id],
            [
                'class' => 'btn btn-sm btn-success',
                'title' => 'เพิ่มกิจกรรม - New Activity',
                'data-header' => 'เพิ่ม: ข้อมูลการติดต่อสื่อสารกับลูกค้า',
            ]);
    endif;
    ?>
    <?php
    if (Yii::$app->user->can('/crm/customer/change-person-in-charge')) :
        echo Html::a('<i class="fa fa-plus"></i> กำหนดผู้รับผิดชอบ',
            ['customer/change-person-in-charge', 'customerId' => $model->id],
            [
                'class' => 'btn btn-sm btn-success modal-add-personincharge',
                'title' => 'กำหนดผู้รับผิดชอบ',
                'data-header' => 'เพิ่ม: ผู้รับผิดชอบ',
            ]);
    endif;
    ?>

    <?php
    if (Yii::$app->user->can('/crm/customer/add-communication')) :
        echo Html::a('<i class="fa fa-plus"></i> เพิ่มกิจกรรม-New Activity',
            ['customer/add-communication', 'customerId' => $model->id],
            [
                'class' => 'btn btn-sm btn-success modal-add-communication',
                'title' => 'เพิ่มข้อมูลการติดต่อสื่อสารกับลูกค้า',
                'data-header' => 'เพิ่ม: ข้อมูลการติดต่อสื่อสารกับลูกค้า',
            ]);
    endif;
    ?>
</p>


<div class="row">
    <div class="col-md-5">

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
            echo Html::tag('div', Html::activeLabel($model, 'currentPersonInCharge') . ': ' . Html::tag('span', $model->currentPersonInChargeFullname));
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

        <p>
            <?php
            echo Html::a('<i class="fa fa-edit"></i> Edit', ['customer/update', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
            ?>
        </p>
    </div>
    <div class="col-md-7">
        <!-- start communication of customer -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-commenting fa-2x"></i> Communication -
                    การติดต่อสื่อสาร</h3>

                <div class="box-tools pull-right">
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
</div>



<?php
echo \kartik\tabs\TabsX::widget([
    'encodeLabels' => false,
    'items' => [
        //Address
        [
            'label' => '<i class="fa fa-address-card fa-2x"></i> ที่อยู่ - Address',
            'content' => '<p>' . $this->render('address/index', [
                    'modelCustomer' => $model,
                    'modelAddressContact' => isset($modelAddressContact) ? $modelAddressContact : null,
                    'modelAddressOffice' => isset($modelAddressOffice) ? $modelAddressOffice : null,
                    'dataProviderAddress' => $dataProviderAddress
                ]) . '</p>',
            'visible' => true,
        ],
        //Survey
        [
            'label' => '<i class="fa fa-list fa-2x"></i> แบบสอบถาม - Questionnaire',
            'content' => '<p>' . $this->render('_questionnaire', ['modelCustomer' => $model,
                    'dataProviderResponse' => $dataProviderResponse,
                ]) . '</p>',
            'visible' => true,
        ],
        //Survey
        [
            'label' => '<i class="fa fa-list fa-2x"></i> แบบส',
            'content' => '<p>' . $this->render('person-in-charge/index', ['modelCustomer' => $model,
                    'dataProviderPersonInCharge' => $dataProviderPersonInCharge
                ]) . '</p>',
            'visible' => true,
        ],
    ],
]);
?>


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

Modal::begin([
    'id' => 'modal-personincharge',
    'size' => 'modal-sm',
]);
Modal::end();
?>








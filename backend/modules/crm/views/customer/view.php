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

\yii\bootstrap\Nav::widget([

]);
?>
<div class="row">
    <div class="col-xs-2 col-sm-2 col-md-2">
        <div align="center"><i class="fa fa-user-circle-o fa-5x" aria-hidden="true"></i></div>
    </div>
    <div class="col-xs-10 col-sm-5 col-md-5">

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
        // if ($model->currentPersonInCharge) {
        echo Html::tag('div', Html::activeLabel($model, 'currentPersonInCharge') . ': ' . Html::tag('span', $model->currentPersonInChargeFullname));
        // }
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


    <div class="col-xs-12 col-sm-5 col-md-5">
        <div style="text-align:left;">
            <?php
            if (Yii::$app->user->can('/crm/customer/add-address')) :
                echo Html::a('<i class="fa fa-plus"></i>  เพิ่มที่อยู่ - New Address',
                    ['customer/add-address', 'customerId' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-success modal-add-address btn-block',
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
                        'class' => 'btn btn-sm btn-success btn-block',
                        'title' => 'เพิ่มกิจกรรม - New Activity',
                        'data-header' => 'เพิ่ม: ข้อมูลการติดต่อสื่อสารกับลูกค้า',
                    ]);
            endif;
            ?>



        </div>




    </div>


</div>


<?php
echo Tabs::widget([
    'encodeLabels' => false,
    'items' => [

        //Communication
        [
            'label' => '<i class="fa fa-commenting"></i> ประวัติการติดต่อสื่อสาร - Communication ',
            'content' => '<p>' . $this->render('communication/index', ['modelCustomer' => $model,
                    'dataProvider' => $dataProviderComm,
                    'searchModel' => $searchComm,
                    'dataProviderResponse' => $dataProviderResponse,
                ]) . '</p>',
            'visible' => true,
        ],
        //Address
        [
            'label' => '<i class="fa fa-address-card"></i> ที่อยู่ - Address',
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
            'label' => '<i class="fa fa-list"></i> แบบสอบถาม - Questionnaire',
            'content' => '<p>' . $this->render('_questionnaire', ['modelCustomer' => $model,
                    'dataProviderResponse' => $dataProviderResponse,
                ]) . '</p>',
            'visible' => true,
        ],

        //Person in charge
        [
            'label' => '<i class="fa fa-user-circle"></i> ผู้รับผิดชอบ ' ,
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








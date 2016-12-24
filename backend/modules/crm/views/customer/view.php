<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
\backend\modules\crm\CustomerAsset::register($this);

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@backend/modules/crm/assets');

$this->title = $model->firstname . '  ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
echo $this->render('toolbar/customer');
?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?= $this->title ?> (ID#<?=$model->id?>)</h3>
        <div class="box-tools pull-right">
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

            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body">


<div class="row">
    <div class="col-xs-12 col-sm-2 col-md-2">
        <div align="center">
         <?php
         if($model->gender == 'F') {
             echo Html::img($directoryAsset.'/img/user-female.png');
         }elseif ($model->gender == 'M') {
             echo Html::img($directoryAsset.'/img/user-male.png');
         }else{
             echo Html::img($directoryAsset.'/img/customer.png');
         }
         ?>
        </div>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-10">

        <?php
        if ($model->prefixname) {
            echo Html::tag('p', Html::activeLabel($model, 'prefixname') . ': ' . Html::tag('span', $model->prefixname));
        }
        ?>
        <?php
        if ($model->prefixname_other) {
            echo Html::tag('p', Html::activeLabel($model, 'prefixname_other') . ': ' . Html::tag('span', $model->prefixname_other));
        }
        ?>

        <?php
        if ($model->firstname) {
            echo Html::tag('p', Html::activeLabel($model, 'firstname') . ': ' . Html::tag('span', $model->firstname . ' ' . $model->lastname));
        }
        ?>
        <?php
        if ($model->gender) {
            echo Html::tag('p', Html::activeLabel($model, 'gender') . ': ' . Html::tag('span', $model->genderName));
        }
        ?>

        <?php
        if ($model->birthday) {
            echo Html::tag('p', Html::activeLabel($model, 'birthday') . ': ' . Html::tag('span', $model->birthday));
        }
        ?>

        <?php
        if ($model->mobile) {
            echo Html::tag('p', Html::activeLabel($model, 'mobile') . ': ' . Html::tag('span', $model->mobile));
        }
        ?>
        <?php
        if ($model->tel) {
            echo Html::tag('p', Html::activeLabel($model, 'tel') . ': ' . Html::tag('span', $model->tel));
        }
        ?>
        <?php
        if ($model->age) {
            echo Html::tag('p', Html::activeLabel($model, 'age') . ': ' . Html::tag('span', $model->age));
        }
        ?>
        <?php
        if ($model->email) {
            echo Html::tag('p', Html::activeLabel($model, 'email') . ': ' . Html::tag('span', $model->email));
        }
        ?>
        <?php
        if ($model->is_vip) {
            echo Html::tag('p', Html::activeLabel($model, 'is_vip') . ': ' . Html::tag('span', $model->is_vip));
        }
        ?>
        <?php
        if ($model->source) {
            echo Html::tag('p', Html::activeLabel($model, 'source') . ': ' . Html::tag('span', $model->sourceName));
        }
        ?>
        <?php
         if ($model->currentPersonInCharge) {
          echo Html::tag('p', Html::activeLabel($model, 'currentPersonInCharge') . ': ' . Html::tag('span', $model->currentPersonInChargeFullname));
         }
        ?>
        <?php
        if ($model->created_by) {

            $timeCreated = \common\siricenter\thaiformatter\ThaiDate::widget([
                'timestamp' => $model->created_at,
                'showTime' => true,
            ]);

            echo html::tag('p', Html::activeLabel($model, 'created_by') . ': ' . Html::tag('span', $model->createdName . " ({$timeCreated})"));
        }
        ?>


        <?php
        if ($model->updated_by) {
            $timeUpdated = Html::tag('span', \common\siricenter\thaiformatter\ThaiDate::widget([
                'timestamp' => $model->updated_at,
                'showTime' => true,
            ]));
            echo Html::tag('p', Html::activeLabel($model, 'updated_by') . ': ' . $model->updatedName . " ({$timeUpdated})");
        }
        ?>

        <p>
            <?php
            echo Html::a('<i class="fa fa-edit"></i> Edit', ['customer/update', 'id' => $model->id], ['class' => 'btn btn-default btn-sm']);
            ?>
        </p>

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



    </div><!-- /.box-body -->

</div><!-- /.box -->




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








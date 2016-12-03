<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\editable\Editable;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 */

$this->title = 'ทั่วไป';
$this->params['breadcrumbs'][] = 'ตั้งค่า';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rcm-setting-index">

    <p>
        <?php /* echo Html::a('Create Rcm Setting', ['create'], ['class' => 'btn btn-success'])*/ ?>
    </p>

    <?php
    echo '<label>ชื่อบริษัทที่จะตั้งเป็นค่าเริ่มต้นสำหรับตัวเลือกต่าง ๆ</label><br>';
    echo Editable::widget([
        'name' => "settings[requestion][manpower_default_company]",
        'asPopover' => true,
        'header' => 'บริษัท',
        'inputType' => Editable::INPUT_DROPDOWN_LIST,
        'data' => \backend\modules\org\models\OrgCompany::getCompanyItems(),
        'options' => ['class' => 'form-control', 'prompt' => 'Select status...'],
        'displayValueConfig' => \backend\modules\org\models\OrgCompany::getCompanyItems(),
    ]);
    echo '<hr>';
    echo '<label>ปิดระบบร้องขอทำให้อ่านได้อย่างเดียว</label><br>';
    echo Editable::widget([
        'name' => "settings[requestion][close_requestion]",
        'asPopover' => false,
        'header' => 'บริษัท',
        'inputType' => Editable::INPUT_SWITCH,
        'data' => ['1' => 'ใช่', 0 => 'ใหม่'],
        'options' => ['class' => 'form-control'],
        // 'displayValueConfig' => \backend\modules\org\models\OrgCompany::getCompanyItems(),
    ]);

    ?>

</div>

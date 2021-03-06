<?php
/**
 * Created by PhpStorm.
 * User: Yuttapong Napikun
 * Date: 7/9/2559
 * Time: 1:24
 */
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;


?>

<?php
NavBar::begin([
    'brandLabel' => '<strong>CRM</strong>',
    'brandUrl' => Yii::$app->urlManager->baseUrl . '/crm/default/index',
]);
echo Nav::widget([
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => [
        ['label' => '<i class="fa fa-dashboard"></i> หน้าแรก', 'url' => ['default/index']],
        ['label' => '<i class="fa fa-user"></i> ลูกค้า', 'url' => ['customer/index'], 'items' => [
            [
                'label' => '<i class="fa fa-search"></i> ค้นหาลูกค้า - Search Customer',
                'url' => ['customer/index']
            ],
            [
                'label' => '<i class="fa fa-plus"></i> เพิ่มลูกค้าใหม่ - New Customer',
                'url' => ['customer/create']
            ],
            [
                'label' => '<i class="fa fa-group"></i> ลูกค้าทั้งหมด - All Customer',
                'url' => ['customer/all']
            ],
            [
                'label' => '<i class="fa fa-commenting"></i> ประวัติการติดต่อของฉัน - My Communication',
                'url' => ['customer/communication']
            ],
        ]],
        ['label' => '<i class="fa fa-list"></i> ประเภทแบบสอบถาม', 'url' => ['survey/index']],
        ['label' => '<i class="fa fa-book "></i> แบบสอบถามลูกค้า', 'url' => ['response/index']],
        [
            'label' => '<i class="fa fa-file-text-o "></i> เอกสาร - Documents',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> แปลงบ้าน', 'url' => ['booking/home']],
                ['label' => '<i class="fa fa-file-text "></i> ใบเสนอราคา - Quatation', 'url' => ['document/quotation']],
                ['label' => '<i class="fa fa-file-text"></i> หนังสือจอง', 'url' => ['document/booking']],
                ['label' => '<i class="fa fa-file-text"></i> สัญญา', 'url' => ['document/contract']],
                ['label' => '<i class="fa fa-file-text"></i> การโอน', 'url' => ['document/transfer']],
            ],
            'visible' => false
        ],
        ['label' => '<i class="fa fa-bar-chart "></i> รายงาน', 'items' => [
            ['label' => '<i class="fa fa-file-excel-o"></i> Export to Excel', 'url' => ['report/excel']],
        ]],
        [
            'label' => '<i class="fa fa-cog "></i> Setting',
            'items' => [
                ['label' => '<i class="fa fa-general"></i> General', 'url' => ['setting/index']],
                ['label' => '<i class="fa fa-list"></i> ประเภทแบบสอบถาม', 'url' => ['setting/survey']],
                ['label' => '<i class="fa fa-man"></i> ผู้ใช้งาน', 'url' => ['setting/ce']],
            ],
            'visible' => true
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

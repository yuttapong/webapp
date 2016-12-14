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
    'brandUrl' => Yii::$app->urlManager->baseUrl . '/crm',
]);
echo Nav::widget([
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => [
        ['label' => '<i class="fa fa-user"></i> ลูกค้า', 'url' => ['customer/index'],'items'=>[
            [
                'label' => '<i class="fa fa-search"></i> ค้นหาลูกค้า - Search Customer',
                'url'=>['customer/search']
            ],
            [
                'label' => '<i class="fa fa-plus"></i> เพิ่มลูกค้าใหม่ - New Customer',
                'url'=>['customer/create']
            ],
            [
                'label' => '<i class="fa fa-user-circle"></i> ลูกค้าที่ฉันรับผิดชอบอยู่ - My Lead',
                'url'=>['customer/mylead']
            ],
            [
                'label' => '<i class="fa fa-group"></i> ลูกค้าทั้งหมด - All Customer',
                'url'=>['customer/all']
            ],
            [
                'label' => '<i class="fa fa-book"></i> แบบสอบถาม - Questionnaire',
                'url'=>['customer/questionnaire']
            ],
            [
                'label' => '<i class="fa fa-commenting"></i> ประวัติการติดต่อของฉัน - My Communication',
                'url'=>['customer/communication']
            ],
        ]],
        ['label' => '<i class="fa fa-list"></i> ประเภทแบบสอบถาม', 'url' => ['survey/index']],
        ['label' => '<i class="fa fa-book "></i> แบบสอบถามลูกค้า', 'url' => ['response/index']],
        ['label' => '<i class="fa fa-file-text-o "></i> Booking', 'items' => [
            ['label' => '<i class="fa fa-home"></i> แปลงบ้าน', 'url' => ['booking/home']],
            ['label' => '<i class="fa fa-home"></i> ใบจอง', 'url' => ['booking/home']],
            ['label' => '<i class="fa fa-home"></i> สัญญา', 'url' => ['booking/home']],
            ['label' => '<i class="fa fa-home"></i> ยื่นกู้', 'url' => ['booking/home']],
        ]],
        ['label' => '<i class="fa fa-bar-chart "></i> รายงาน', 'items' => [
            ['label' => '<i class="fa fa-file-excel-o"></i> Export to Excel', 'url' => ['report/excel']],
        ]],
        ['label' => '<i class="fa fa-cog "></i> Setting', 'items' => [
            ['label' => '<i class="fa fa-general"></i> General', 'url' => ['setting/index']],
            ['label' => '<i class="fa fa-list"></i> ประเภทแบบสอบถาม', 'url' => ['setting/survey']],
            ['label' => '<i class="fa fa-man"></i> ผู้ใช้งาน', 'url' => ['setting/ce']],
        ]],
    ],
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

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
    'brandLabel' => '<strong>REMS</strong>',
    'brandUrl' => Yii::$app->urlManager->baseUrl . '/rems/default/index',
]);
echo Nav::widget([
    'encodeLabels' => false,
    'activateParents' => true,
    'items' => [
        ['label' => '<i class="fa fa-dashboard"></i> หน้าแรก', 'url' => ['default/index']],
        ['label' => '<i class="fa fa-dashboard"></i> ข้อมูลโครงการ', 'url' => ['project/index']],
        [
            'label' => '<i class="fa fa-list"></i> Prometions',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> ทำสัญญาใหม่', 'url' => ['promotion/index']],
                ['label' => '<i class="fa fa-file-text "></i> รายการทำสัญญา', 'url' => ['promotion/manage']],
            ],
            'visible' => true
        ],
        [
            'label' => '<i class="fa fa-file-text-o "></i> การจอง-Booking',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> จองบ้าน', 'url' => ['booking/new']],
                ['label' => '<i class="fa fa-file-text "></i> ใบจองทั้งหมด', 'url' => ['booking/index']],
                ['label' => '<i class="fa fa-file-text"></i> รายการยกเลิก', 'url' => ['booking/list-canceled']],
                ['label' => '<i class="fa fa-file-text"></i> สัญญา', 'url' => ['document/contract']],
                ['label' => '<i class="fa fa-file-text"></i> การโอน', 'url' => ['document/transfer']],
            ],
            'visible' => true
        ],
         [
            'label' => '<i class="fa fa-list"></i> หนังสือสัญญา',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> ทำสัญญาใหม่', 'url' => ['contract/new']],
                ['label' => '<i class="fa fa-file-text "></i> รายการทำสัญญา', 'url' => ['contract/index']],
            ],
            'visible' => true
        ],
        [
            'label' => '<i class="fa fa-user"></i> การยืนกู้',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> ทำสัญญาใหม่', 'url' => ['contract/new']],
                ['label' => '<i class="fa fa-file-text "></i> รายการทำสัญญา', 'url' => ['contract/index']],
            ],
            'visible' => true
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

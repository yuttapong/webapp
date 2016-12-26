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
        ['label' => '<i class="fa fa-dashboard"></i> Dashboard', 'url' => ['default/index']],
        ['label' => '<i class="fa fa-home"></i> Property', 'url' => ['project/index']],
        [
            'label' => '<i class="fa fa-list"></i> Promotions',
            'url' => ['promotion/index'],
            'visible' => true
        ],
         [
            'label' => '<i class="fa fa-user"></i> Customer',
            'url' => ['customer/index'],
            'visible' => true
        ],
        [
            'label' => '<i class="fa fa-plus "></i> New document',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> จองบ้าน', 'url' => ['booking/new']],
                ['label' => '<i class="fa fa-file-text "></i> สร้างสัญญา', 'url' => ['contract/new']],
                ['label' => '<i class="fa fa-file-text"></i> สร้างเอกสารยื่นกู้', 'url' => ['loan/new']],
                ['label' => '<i class="fa fa-file-text"></i> สร้างหนังสือการโอน', 'url' => ['transfer/new']],
                ['label' => '<i class="fa fa-money"></i> รับชำระเงิน', 'url' => ['payment/new']],
            ],
            'visible' => true
        ],
                [
            'label' => '<i class="fa fa-file "></i> All documents',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> ใบจอง', 'url' => ['booking/index']],
                ['label' => '<i class="fa fa-file-text "></i> สัญญาจะซื้อจะขาย', 'url' => ['contract/index']],
                ['label' => '<i class="fa fa-file-text"></i> เอกสารยื่นกู้', 'url' => ['loan/index']],
                ['label' => '<i class="fa fa-file-text"></i> หนังสือโอน', 'url' => ['transfer/index']],
            ],
            'visible' => true
        ],
        [
            'label' => '<i class="fa fa-file-text-o "></i> Booking',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> จองบ้าน', 'url' => ['booking/new']],
                ['label' => '<i class="fa fa-file-text "></i> ใบจองทั้งหมด', 'url' => ['booking/index']],
                ['label' => '<i class="fa fa-file-text"></i> รายการยกเลิก', 'url' => ['booking/list-canceled']],
                ['label' => '<i class="fa fa-file-text"></i> สัญญา', 'url' => ['document/contract']],
                ['label' => '<i class="fa fa-file-text"></i> การโอน', 'url' => ['document/transfer']],
            ],
            'visible' => false
        ],
         [
            'label' => '<i class="fa fa-list"></i> Contract',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> สร้างสัญญาใหม่', 'url' => ['contract/new']],
                ['label' => '<i class="fa fa-file-text "></i> รายการทำสัญญาทั้งหมด', 'url' => ['contract/index']],
            ],
            'visible' => false
        ],
        [
            'label' => '<i class="fa fa-user"></i> Loan',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> สร้างเอกสารยื่นกู้', 'url' => ['loan/new']],
                ['label' => '<i class="fa fa-file-text "></i> รายการยื่นกู้ทั้งหมด', 'url' => ['loan/index']],
            ],
            'visible' => false
        ],
        [
            'label' => '<i class="fa fa-book"></i> Transfering',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> สร้างหนังสือโอนใหม่', 'url' => ['transfer/new']],
                ['label' => '<i class="fa fa-file-text "></i> เอกสารโอนทั้งหมด', 'url' => ['transfer/index']],
            ],
            'visible' => false
        ],
        [
            'label' => '<i class="fa fa-book"></i> Payment',
            'items' => [
                ['label' => '<i class="fa fa-file-text"></i> รายชำระเงิน', 'url' => ['payment/index']],
                ['label' => '<i class="fa fa-file-text "></i> รายการครบกำหนดชำระเงิน', 'url' => ['payment/index']],
            ],
            'visible' => true
        ],
        [
            'label' => '<i class="fa fa-cog "></i> Setting',
            'items' => [
                ['label' => '<i class="fa fa-home"></i> Project Profile', 'url' => ['setting/index']],
                ['label' => '<i class="fa fa-home"></i> User', 'url' => ['setting/user']],
            ],
            'visible' => true
        ],
    ],
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

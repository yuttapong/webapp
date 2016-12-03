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
    'brandLabel' => '<strong>Report</strong>',
    'brandUrl' => Yii::$app->urlManager->baseUrl . '/crm',
]);
echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<i class="fa fa-search  fa-1x"></i> โครงการบ้าน',
            'url' => ['project/index'],
            'items' => [
                ['label' => '<i class="fa fa-list  fa-1x"></i> Executtive Sales Summary Report By Project', 'url' => ['project/index']],
                ['label' => '<i class="fa fa-book fa-1x"></i> แบบสอบถามลูกค้า', 'url' => ['response/index']],
                ['label' => '<i class="fa fa-commenting fa-1x"></i> ประวัติการติดตามลูกค้า', 'url' => ['communication/index']],
                ['label' => '<i class="fa fa-bar-chart fa-1x"></i> รายงาน', 'url' => ['report/excel']],
            ]
        ],


    ],
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

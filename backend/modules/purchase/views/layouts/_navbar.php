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
    'brandLabel' => '<strong>ระบบจัดซื้อ</strong>',
    'brandUrl' => Yii::$app->urlManager->baseUrl.'/purchase',
]);
echo Nav::widget([
    'encodeLabels' => false,
    'items' => [
        ['label' => '<i class="fa fa-search  fa-1x"></i> วัสดุ', 'url' => ['inventory/index']],
    	['label' => '<i class="fa fa-search  fa-1x"></i> หน่วย', 'url' => ['unit/index']],
    		['label' => '<i class="fa fa-search  fa-1x"></i> ร้านค่้า', 'url' => ['vendor/index']],
     
    ],
    'options' => ['class' => 'navbar-nav'],
]);
NavBar::end();
?>

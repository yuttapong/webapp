<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
   // 'brandLabel' => \yii\helpers\Html::img('http://www.sirivalai.com/images/logo.png',['class'=>'img img-responsive']),
    //'brandLabel'=>'บริษัท สิริวลัย พร๊อพเพอร์ตี้ จำกัด',
    'brandLabel'=>'YOUR COMPANY',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [
    ['label' => '<i class="fa fa-book"></i> บทความ', 'url' => ['/blog/index']],
    ['label' => '<i class="fa fa-building"></i> บ้านเดี่ยว', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> ทาว์โฮม', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> คอนโดมีเนียม', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> บ้านเดี่ยว', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-envelope"></i> ติดต่อ', 'url' => ['/site/contact']],
    ['label' => '<i class="fa fa-group"></i> ร่วมงานกับเรา', 'url' => ['/recruitment']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => '<i class="fa fa-user"></i> ลงทะเบียน', 'url' => ['/site/signup']];
    $menuItems[] = ['label' => '<i class="fa fa-key"></i> เข้าสู่ระบบ', 'url' => ['/site/login']];
} else {

    $menuItems[] = [
        'label' => 'สวัสดี:  (' . Yii::$app->user->identity->username . ')',
        'items'=>[
            ['label' => '<i class="fa fa-user"></i>  โปรไฟล์', 'url' => ['/profile/index']],
            ['label' => '<i class="fa fa-edit"></i> แก้ไขโปรไฟล์', 'url' => ['/profile/update']],
            [ 'label'=>'<i class="fa fa-home"></i> สำหรับพนักงานบริษัท','url' => ['backend/web'],'linkOptions' => ['data-method' => 'post']],
            [ 'label'=>'<i class="fa fa-lock"></i> ออกจากระบบ','url' => ['/site/logout'],'linkOptions' => ['data-method' => 'post']],

        ]
    ];
}
echo Nav::widget([
    'encodeLabels' => false,
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
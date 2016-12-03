<?php
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;

NavBar::begin([
    // 'brandLabel' => \yii\helpers\Html::img('https://cdn3.iconfinder.com/data/icons/office-business-bg-vol-2-part-2/512/laptop-32.png',['class'=>'img img-responsive']),
    //'brandLabel'=>'บริษัท สิริวลัย พร๊อพเพอร์ตี้ จำกัด',
    'brandLabel'=>'<strong>app.siricenter.com</strong>',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default',
    ],
]);
$menuItems = [
    ['label' => '<i class="fa fa-book"></i> บทความ', 'url' => ['/blog/index']],
    /*
    ['label' => '<i class="fa fa-building"></i> บ้านเดี่ยว', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> ทาว์โฮม', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> คอนโดมีเนียม', 'url' => ['/site/about']],
    ['label' => '<i class="fa fa-building"></i> บ้านเดี่ยว', 'url' => ['/site/about']],
    */

    ['label' => '<i class="fa fa-envelope"></i> แจ้งปัญหาการใช้งาน', 'url' => ['/site/contact']],
    ['label' => '<i class="fa fa-desktop"></i> ระบบ Intranet สำหรับพนักงาน', 'url' =>Yii::$app->urlManagerBackend->baseUrl,]
];
if (Yii::$app->user->isGuest) {
    // $menuItems[] = ['label' => '<i class="fa fa-key"></i> เข้าสู่ระบบ', 'url' => ['/site/login']];
} else {

    $menuItems[] = [
        'label' => 'สวัสดี:  (' . Yii::$app->user->identity->username . ')',
        'items'=>[
            ['label' => '<i class="fa fa-user"></i>  โปรไฟล์', 'url' => ['/profile/index']],
            ['label' => '<i class="fa fa-edit"></i> แก้ไขโปรไฟล์', 'url' => ['/profile/update']],
            [ 'label'=>'<i class="fa fa-home"></i> สำหรับพนักงานบริษัท','url' => Yii::$app->urlManagerBackend->baseUrl,'linkOptions' => ['data-method' => 'post']],
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
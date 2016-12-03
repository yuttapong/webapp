<?php
NavBar::begin([
    'brandLabel' => 'Siricenter Administration',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-default',
    ],
]);
$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = ['label' => 'บทความ', 'url' => ['/blog/index']];
    $menuItems[] = ['label' => 'ผู้ใช้งาน', 'url' => ['/manage-user/index']];
    $menuItems[] = ['label' => 'ข้อมูลกลุ่มข้อมูล', 'url' => ['/sys-table/index']];
    $menuItems[] = ['label' => 'ข้อมูลพื้นฐาน', 'url' => ['/sys-basic-data/index']];
    $menuItems[] = ['label' => 'โมดูล', 'url' => ['/sys-module/index']];
    $menuItems[] = ['label' => 'ตั้งค่า', 'url' => ['/setting/default']];
    $menuItems[] = [
        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
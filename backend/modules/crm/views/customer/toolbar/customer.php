<?php
use yii\bootstrap\Nav;
echo Nav::widget([
    'options' => ['class' => 'nav-pills'],
    'encodeLabels' => false,
    'items' => [
        [
            'label' => '<i class="fa fa-meh-o"></i> ลูกค้าที่ฉันรับผิดชอบ',
            'url' => ['customer/mylead'],
            'linkOptions' => [],
        ],
        [
            'label' => '<i class="fa fa-search"></i> ค้นหาลูกค้า',
            'url' => ['customer/search'],
            'linkOptions' => [],
        ],
    ]
]);
?>
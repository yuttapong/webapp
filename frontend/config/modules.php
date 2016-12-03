<?php
return [
    'recruitment' => [
        'class' => 'frontend\modules\recruitment\Module',
        'defaultRoute' => 'position/index',
    ],
    'gridview' => [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to
        // use your own export download action or custom translation
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
    ],
];
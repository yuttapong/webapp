<?php
return [
    'admin' => [
            'class' => 'mdm\admin\Module',
            'layout' => 'left-menu',
            'menus' => [
                'assignment' => [
                    'label' => 'กำหนดสิทธิ์' // change label
                ],
              //  'route' => null, // disable menu
            ],
    ],
    'datecontrol' => [
        'class' => 'kartik\datecontrol\Module',
        // format settings for displaying each date attribute
        'displaySettings' => [
            'date' => 'dd/MM/yyyy',
            'time' => 'hh:mm:ss a',
            'datetime' => 'dd/MM/yyyy hh:mm:ss a',
        ],

        // format settings for saving each date attribute
        'saveSettings' => [
            'date' => 'php:Y-m-d',
            'time' => 'php:H:i:s',
            'datetime' => 'php:Y-m-d H:i:s',
        ],
        // automatically use kartik\widgets for each of the above formats
        'autoWidget' => true,

    ],
    'gridview' => [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to
        // use your own export download action or custom translation
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
    ],
    ///////////////// Siricenter /////////////////////////
    'org' => [
        'class' => 'backend\modules\org\Org',
        'defaultRoute' => 'company/index',
    ],
    // Setting
    'setting' => [
        'class' => 'backend\modules\setting\Setting',
        'defaultRoute' => 'default/index',
    ],
    'hr' => [
        'class' => 'backend\modules\hr\Hr',
    ],
    'lv' => [
        'class' => 'backend\modules\lv\Lv',
    ],
    'inventory' => [
        'class' => 'backend\modules\inventory\Inventory',
    ],
    'recruitment' => [
        'class' => 'backend\modules\recruitment\Module',
        'defaultRoute' => 'request/index',
    ],
    'tree' => [
        'class' => 'backend\modules\tree\Module',
    ],
    'treemanager' => [
        'class' => '\kartik\tree\Module',
        'controllerMap' => [
            'node' => 'backend\modules\org\controllers\NodeController'
        ]
    ],
    'crm' => [
        'class' => 'backend\modules\crm\Module',
    ],
    'gii' => [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '103.22.180.170'] // adjust this to your needs
    ],
    'qtn' => [
        'class' => 'backend\modules\qtn\Module',
    ],
    'fix' => [

        'class' => 'backend\modules\fix\Module',
    ],
    'report' => [

        'class' => 'backend\modules\report\Module',
    ],
    'document' => [

        'class' => 'backend\modules\document\Module',

    ],
    'rems' => [
            'class' => 'backend\modules\rems\Rems',
    ],

];
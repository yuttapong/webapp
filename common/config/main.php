<?php

return [
    'language' => 'th_TH',
    'timezone' => 'Asia/Bangkok',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
        'i18n' => [ // this example only if you don't have i18n defined in any other way.
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // 'yii\rbac\PhpManager'
        ],
    ],
];

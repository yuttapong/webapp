<?php
/**
 * Developed By ::  Yuttapong Napikun (yuttaponk@gmail.com) , Charin Kamchompoo
 * Since:: June, 2016
 */
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost:3306;dbname=siricenter_main',
            'username' => 'siricenter_app',
            'password' => 'oco0XhU2',
            'charset' => 'utf8',
        ],
        'dbSC' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost:3306;dbname=siricenter_app',
            'username' => 'siricenter_app',
            'password' => 'oco0XhU2',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mail.sirivalai.co.th',
                'username' => 'noreply@sirivalai.co.th',
                'password' => 's1234',
                'port' => '25',
                'encryption' => 'tls',
            ],
        ],
    ],
];

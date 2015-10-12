<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager'  => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false
        ],
        'i18n'        => [
            'translations' => [
                '*' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap'  => [
                        'app'      => 'app.php',
                        'error'    => 'errors.php',
                        'label'    => 'labels.php',
                        'button'   => 'buttons.php',
                        'validate' => 'validates.php',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'db'          => [
            'class'   => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache'       => [
            'class'     => 'yii\redis\Cache',
            'keyPrefix' => md5(dirname(__FILE__))
        ],
        'redis'       => [
            'class'    => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port'     => 6379
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'viewPath'         => '@common/mail',
            'useFileTransport' => true,
        ],
        'curl'        => [
            'class' => 'linslin\yii2\curl\Curl'
        ],
    ],
];

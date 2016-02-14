<?php

require(__DIR__ . DIRECTORY_SEPARATOR . 'container.php');

return [
    'language'   => 'ru-RU',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap'  => ['log'],
    'components' => [
        'urlManager'    => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false
        ],
        'i18n'          => [
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
        'authManager'   => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache',
        ],
        'db'            => [
            'class'   => 'yii\db\Connection',
            'charset' => 'utf8',
        ],
        'cache'         => [
            'class'     => 'yii\redis\Cache',
            'keyPrefix' => md5(dirname(__FILE__))
        ],
        'redis'         => [
            'class'    => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port'     => 6379
        ],
        'mailer'        => [
            'class'    => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
        'curl'          => [
            'class' => 'linslin\yii2\curl\Curl'
        ],
        'thumbnail'     => [
            'class'      => 'himiklab\thumbnail\EasyThumbnail',
            'cacheAlias' => 'assets/thumbnails',
        ],
        'consoleRunner' => [
            'class' => 'vova07\console\ConsoleRunner',
            'file'  => '@yiiBase/yii'
        ],
        'log'           => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class'      => 'yii\log\EmailTarget',
                    'levels'     => ['error', 'warning'],
                    'categories' => [
                        'yii\db\*',
                        'yii\web\HttpException:*',
                    ],
                    'except'     => [
                        'yii\web\HttpException:404',
                    ],
                    'message'    => [
                        'from'    => ['error@finder.thorxml.com'],
                        'to'      => ['chumoleg@yandex.ru'],
                        'subject' => 'Error finder',
                    ],
                ],
            ],
        ],
    ],
];

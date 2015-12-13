<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-frontend',
    'basePath'            => dirname(__DIR__),
    'bootstrap'           => ['log', 'thumbnail'],
    'controllerNamespace' => 'frontend\controllers',
    'modules'             => [
        'ajax'            => 'frontend\modules\ajax\AjaxModule',
        'personalCabinet' => 'frontend\modules\personalCabinet\PersonalCabinetModule'
    ],
    'components'          => [
        'authClientCollection' => [
            'class'   => 'yii\authclient\Collection',
            'clients' => [
                'yandex'    => [
                    'class'        => 'yii\authclient\clients\YandexOAuth',
                    'clientId'     => 'yandex_client_id',
                    'clientSecret' => 'yandex_client_secret',
                ],
                'google'    => [
                    'class'        => 'yii\authclient\clients\GoogleOAuth',
                    'clientId'     => 'google_client_id',
                    'clientSecret' => 'google_client_secret',
                ],
                'facebook'  => [
                    'class'        => 'yii\authclient\clients\Facebook',
                    'clientId'     => 'facebook_client_id',
                    'clientSecret' => 'facebook_client_secret',
                ],
                'vkontakte' => [
                    'class'        => 'yii\authclient\clients\VKontakte',
                    'clientId'     => 'vkontakte_client_id',
                    'clientSecret' => 'vkontakte_client_secret',
                ],
                'linkedin'  => [
                    'class'        => 'yii\authclient\clients\LinkedIn',
                    'clientId'     => 'linkedin_client_id',
                    'clientSecret' => 'linkedin_client_secret',
                ],
                'twitter'   => [
                    'class'          => 'yii\authclient\clients\Twitter',
                    'consumerKey'    => 'twitter_consumer_key',
                    'consumerSecret' => 'twitter_consumer_secret',
                ],
            ],
        ],
        'urlManager'           => [
            'rules' => [
                '<module:\w+><controller:\w+>/<action:\w+>/<id:\d+>' => '<module><controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>'             => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>'                      => '<controller>/<action>',
            ]
        ],
        'user'                 => [
            'identityClass'   => 'common\models\user\User',
            'enableAutoLogin' => true,
        ],
        'log'                  => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler'         => [
            'errorAction' => 'site/error',
        ],
    ],
    'params'              => $params,
];

<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                  => 'app-backend',
    'basePath'            => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'modules'             => [
        'management' => [
            'class'        => 'backend\modules\management\ManagementModule',
            'defaultRoute' => 'user',
            'as access'    => [
                'class' => 'yii\filters\AccessControl',
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['accessToBackend'],
                    ]
                ]
            ],
        ]
    ],
    'components'          => [
        'user'         => [
            'identityClass'   => 'common\models\user\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params'              => $params,
];

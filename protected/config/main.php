<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Trading of the Future',

	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'ext.giix.components.*',
	),
	// application components
	'components'=>array(
        'authManager'=>array(
            'class' => 'CPhpAuthManager',
            'defaultRoles' => array('guest', 'admin'),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'useStrictParsing' => false,
            #'showScriptName'=>YII_DEBUG,
            'rules' => array(
                '/' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/registration',
                'recover' => 'site/resetPasswordRequest',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:[\d-]+>' => '<controller>/<action>',
                '<controller:\w+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
		'db'=>array(
            'connectionString'=>'mysql:host=localhost;dbname=carcure',
            'username'=>'astra_db',
            'password'=>'luL0hIA4',
            'charset'=>'utf8',
            'schemaCachingDuration'=>3600,
		),
		'bootstrap' => array(
            'class' => 'ext.bootstrap.components.Bootstrap',
            'responsiveCss' => true,
        ),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        'file_upload_size_limit' => 8 * 1024 * 1024,
        'file_upload_allowed_extension' => array('jpg', 'jpeg', 'gif', 'png', 'doc', 'xls', 'docx', 'xlsx'),
        'image_upload_allowed_extension' => array('jpg', 'jpeg', 'gif', 'png'),
	),
);
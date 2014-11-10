<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Performance Machine',
    'theme' => 'optimasale',
    'sourceLanguage' => 'en_us',
    'language' => 'pt_br',
    'preload' => array(
        'log',
    ),
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'components' => array(
        'db' => array(
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/database.sqlite',
            'tablePrefix' => 'tbl_',
        ),
        'user' => array(
            'allowAutoLogin' => true,
        ),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => 'juliancesar@gmail.com',
        'jmeterPath' => '/home/perfmachine/apache-jmeter-2.8',
        'jmeterServiceUrl' => 'http://springfield.selfip.com/pm',
        'maxTriesToGenerateReport' => 5,
        'baseUrl' => 'http://www.perfmachine.com.br/index.php',
    ),
);
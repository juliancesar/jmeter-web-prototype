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
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
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
//    'params' => array(
//        'adminEmail' => 'juliancesar@gmail.com',
//        'jmeterServiceUrl' => 'http://springfield.selfip.com/pm',
//        'maxTriesToGenerateReport' => 5,
//        'baseUrl' => 'http://www.perfmachine.com.br/index.php',
//    ),
    'params' => array(
        //'adminEmail' => 'juliancesar@gmail.com',
        'jmeterPath' => '/home/00968514901/JMeter/apache-jmeter-2.11_d_1',
        'jmeterServiceUrl' => 'http://dev.local/perfmachine/www/trunk/',
        'maxTriesToGenerateReport' => 5,
        // 'baseUrl' => 'http://www.perfmachine.com.br/index.php',
    ),
);

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
        // Minimize and optimize CSS and JS
        'clientScript' => array(
            'class' => 'ext.minify.EClientScript',
            'combineScriptFiles' => true,
            'optimizeScriptFiles' => false,
            'combineCssFiles' => true,
            'optimizeCssFiles' => false,
            'packages' => array(
//                'jquery' => array(
//                    'baseUrl' => 'js/',
//                    'js' => array('jquery-1.9.1.min.js')
//                ),
            ),
            // Retira os scripts incompativeis com o jQuery 1.9.1
            'scriptMap' => array(
                'jquery.maskedinput.min.js' => false,
                'jquery.maskedinput.js' => false,
                'jquery.ba-bbq.min.js' => false,
                'jquery.ba-bbq.js' => false,
            ),
        ),
        'db' => array(
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/database.sqlite',
            'tablePrefix' => 'tbl_',
        ),
        'cache' => array(
            'class' => 'CApcCache',
            'hashKey' => true,
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
                array(
                    'class' => 'CEmailLogRoute',
                    'levels' => 'error, warning, info',
                    'emails' => 'juliancesar@gmail.com',
                    'subject' => '[PerfMachine] Erro no Sistema',
                    'enabled' => true,
                    'headers' => array(
                        'MIME-Version: 1.0',
                        'Content-Type: text/plain; charset=UTF-8',
                        'Return-Path: admin@perfmachine.com.br',
                        'From: admin@perfmachine.com.br',
                    ),
                ),
            ),
        ),
    ),
    'params' => array(
        'adminEmail' => 'juliancesar@gmail.com',
        'jmeterServiceUrl' => 'http://springfield.selfip.com/pm',
        'baseUrl' => 'http://www.perfmachine.com.br/index.php',
        'maxTriesToGenerateReport' => 5,
    ),
);
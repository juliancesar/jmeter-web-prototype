<?php

$arProduction = array('perfmachine.com.br', 'www.perfmachine.com.br', 'perfmachine.com', 'www.perfmachine.com');
$arJMeterServer = array('springfield.selfip.com');

if (in_array($_SERVER['SERVER_NAME'], $arProduction)) {

    // Configurações de PRODUÇÃO
    $yii = dirname(__FILE__) . '/../yii-1.1.13.e9e4a0/framework/yiilite.php';
    $config = dirname(__FILE__) . '/protected/config/prod.php';
} elseif (in_array($_SERVER['SERVER_NAME'], $arJMeterServer)) {

    // Configurações para o JMeter Server
    $yii = dirname(__FILE__) . '/../yii-1.1.13.e9e4a0/framework/yiilite.php';
    $config = dirname(__FILE__) . '/protected/config/jmeter.php';
} else {

    // Configurações de DESENVOLVIMENTO
    $yii = dirname(__FILE__) . '/../../infra/framework/yii-1.1.15.022a51/framework/yii.php';
    $config = dirname(__FILE__) . '/protected/config/main.php';

    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 2);
}

require_once($yii);
Yii::createWebApplication($config)->run();




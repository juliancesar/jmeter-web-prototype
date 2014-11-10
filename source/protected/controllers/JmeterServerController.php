<?php

ini_set('soap.wsdl_cache_enable', 300);
ini_set('soap.wsdl_cache_ttl', 300);

ini_set('max_execution_time', 600);
ini_set('default_socket_timeout', 600);
set_time_limit(600);

class JMeterServerController extends CController {

    public function actions() {
        return array(
            'service' => array(
                'class' => 'CWebServiceAction',
            ),
        );
    }

    /**
     * @param string identification test
     * @param string complete JMX
     * @param string email to send report
     * @return string complete report
     * @soap
     */
    public function startTest($idTest, $jmx, $email) {
        try {
            return Jmeter::startTest($idTest, $jmx, $email, false);
        } catch (Exception $ex) {
            return $ex;
        }
    }

    /**
     * @param string identification test
     * @param int max tries to generate report
     * @return string complete report
     * @soap
     */
    public function getReport($idTest, $tries) {
        $jmeterRuntimePath = Yii::app()->basePath . '/runtime/jmeter';
        $reportFile = $jmeterRuntimePath . '/results_' . $idTest . '.html';
    
        for ($i = 1; $i <= $tries; $i++) {
            if (file_exists($reportFile)) {
                return file_get_contents($reportFile);
                Yii::app()->end();
            } else {
                sleep(1);
            }
        }
        
        return '<div style="text-align: center;">Nenhum relatório foi encontrado ou ele ainda não terminou de ser gerado.</div>';
    }

    /**
     * @param string identification test
     * @param int max tries to generate report
     * @return string complete JTL report
     * @soap
     */
    public function getJtlReport($idTest, $tries) {
        $jmeterRuntimePath = Yii::app()->basePath . '/runtime/jmeter';
        $jtlFile = $jmeterRuntimePath . '/test_' . $idTest . '.jtl';
        
        if (!file_exists($jtlFile)) {
            return '<div style="text-align: center;">Nenhum relatório foi encontrado.</div>';
        } else {
            return file_get_contents($jtlFile);
        }
    }

}
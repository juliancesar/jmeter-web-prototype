<?php

// Descomentar essas flags quando alterar o lado servidor (JMeterServerController)
ini_set('soap.wsdl_cache_enable', 300);
ini_set('soap.wsdl_cache_ttl', 300);

ini_set('max_execution_time', 600);
ini_set('default_socket_timeout', 600);
set_time_limit(600);

class JmeterController extends Controller {

    public function actionCustom() {
        $data = array();
        $data["report"] = "";

        // Seleciona o nome do arquivo
        Yii::app()->user->setState('script_custom', uniqid('script_custom_'));

        $this->render('index', $data);
    }

    public function actionSimple() {
        $data = array();
        $data["report"] = "";

        // Seleciona o nome do arquivo
        Yii::app()->user->setState('script_simple', uniqid('script_simple_'));

        $this->render('simple', $data);
    }

    public function actionRecoveryreport() {
        $data = array();
        $data["report"] = "";

        $this->render('recoveryreport', $data);
    }

    public function actionRecoveryreportwithid($id) {
        $data = array();
        $data['id'] = $id;
        $data['report'] = '';

        $this->render('recoveryreportwithid', $data);
    }

    public function actionUpdateAjax() {
        if ($this->getTestFlag())
            throw new Exception("Teste rodando");

        $this->startTestFlag();

        $idTest = Yii::app()->user->getState('script_custom');

        // Le o arquivo
        $name = Yii::app()->basePath . '/runtime/jmeter/' . $idTest . '.jmx';

        $fileData = file_get_contents($name);

        $this->sendMail($idTest, $fileData);
        
        $client = new SoapClient(Yii::app()->params['jmeterServiceUrl'] . '/index.php?r=JmeterServer/service');
        $ret = trim($client->startTest($idTest, $fileData));

        // Se deu problema para pegar o relatório tenta novamente com a função específica
        if (empty($ret))
            $ret = $client->getReport($idTest, Yii::app()->params['maxTriesToGenerateReport']);

        // Salva localmente
        $this->saveReport($idTest, $ret);
        
        Yii::app()->user->setState('script_simple', null);

        $data = array();
        $data["report"] = $ret;
        $this->renderPartial('_ajaxContent', $data, false, false);

        $this->stopTestFlag();
    }

    private function createRuntimeDir() {
        $dir = Yii::app()->basePath . '/runtime/jmeter/';

        if (!file_exists($dir))
            mkdir($dir);
    }

    public function actionUpdateAjaxSimple($url, $path, $threads, $duration, $timeout, $assertion, $email, $rampup, $thinktime) {

        if ($this->getTestFlag())
            throw new Exception("Teste rodando");

        $this->startTestFlag();

        $this->createRuntimeDir();

        $idTest = Yii::app()->user->getState('script_simple');

        // Le o arquivo
        $jmeterRuntimePath = Yii::app()->basePath . '/jmeter/simple-test.jmx';
        $newName = Yii::app()->basePath . '/runtime/jmeter/' . $idTest . '.jmx';

        copy($jmeterRuntimePath, $newName) or die("Unable to copy $jmeterRuntimePath to $newName.");

        $jmeterRuntimePath = $newName;

        $fileData = file_get_contents($jmeterRuntimePath);

        // Replaces
        $fileData = str_replace('${__P(urlToSend,netbeans.local)}', $url, $fileData);
        $fileData = str_replace('${__P(path,/)}', $path, $fileData);
        $fileData = str_replace('${__P(threads,1)}', $threads, $fileData);
        $fileData = str_replace('${__P(iterations,1)}', 1, $fileData);
        $fileData = str_replace('${__P(rampup,1)}', $rampup, $fileData);
        $fileData = str_replace('${__P(assertion,)}', $assertion, $fileData);

        // Novos parametros
        $fileData = str_replace('${__P(duration,30)}', $duration, $fileData);
        $fileData = str_replace('${__P(timeout,30)}', $timeout, $fileData);
        $fileData = str_replace('${__P(thinktime,100)}', $thinktime, $fileData);

        $this->sendMail($idTest, $fileData);

        $client = new SoapClient(Yii::app()->params['jmeterServiceUrl'] . '/index.php?r=JmeterServer/service');
        $ret = $client->startTest($idTest, $fileData, $email);

        // Se deu problema para pegar o relatório tenta novamente com a função específica
        if (empty($ret))
            $ret = $client->getReport($idTest, Yii::app()->params['maxTriesToGenerateReport']);

        Yii::app()->user->setState('script_simple', null);

        // Salva localmente
        $this->saveReport($idTest, $ret);

        $data = array();
        $data["report"] = $ret;
        $this->renderPartial('_ajaxContent', $data, false, false);

        Recent::createRegister($url, $idTest);

        $this->stopTestFlag();
    }

    public function sendMail($idTesteJMeter, $jmx) {
        $name = 'Serviço de Testes do JMeter';
        $subject = '[JMeter] Teste iniciado (' . $idTesteJMeter . ')';
        $headers = "From: $name <noreply@taskmachine.com.br>\r\n" .
                "Reply-To: noreply@taskmachine.com.br\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8";

        // mail(Yii::app()->params['adminEmail'], $subject, htmlentities($jmx), $headers);
    }

    public function saveReport($idTesteJMeter, $report) {
        $jmeterRuntimePath = Yii::app()->basePath . '/runtime/jmeter';
        $reportFile = $jmeterRuntimePath . '/results_' . $idTesteJMeter . '.html';

        file_put_contents($reportFile, $report);
    }

    public function getLocalReport($idTesteJMeter) {
        $jmeterRuntimePath = Yii::app()->basePath . '/runtime/jmeter';
        $reportFile = $jmeterRuntimePath . '/results_' . $idTesteJMeter . '.html';

        if (file_exists($reportFile)) {
            return file_get_contents($reportFile);
        } else {
            return null;
        }
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $this->createRuntimeDir();

        $folder = Yii::app()->basePath . '/runtime/jmeter/';
        $allowedExtensions = array("jmx");
        $sizeLimit = 1 * 1024 * 1024;
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder, true);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        //$fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        //$fileName = $result['filename']; //GETTING FILE NAME

        $oldName = $folder . $result['filename'];
        $newName = $folder . Yii::app()->user->getState('script_custom') . '.jmx';

        rename($oldName, $newName) or die("Unable to rename $oldName to $newName.");

        echo $return;
    }

    public function actionStatus() {
        try {
            $client = new SoapClient(Yii::app()->params['jmeterServiceUrl'] . '/index.php?r=Server/service');
            $client->ping();

            echo "true";
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * Verifica se existe local
     * 
     * @param type $id
     */
    public function actionRecoveryreportcall($id) {
        $data = array();

        $data["report"] = $this->getLocalReport($id);

        if ($data["report"] == null) {
            try {
                $client = new SoapClient(Yii::app()->params['jmeterServiceUrl'] . '/index.php?r=JmeterServer/service');
                $ret = $client->getReport($id, Yii::app()->params['maxTriesToGenerateReport']);

                $data["report"] = $ret;
            } catch (Exception $ex) {
                $data["report"] = $ex->getMessage();
            }
        }

        $this->renderPartial('_ajaxContent', $data, false, false);
    }

    public function actionViewjmx() {
        $fileData = file_get_contents(Yii::app()->basePath . '/runtime/jmeter/' . Yii::app()->user->getState('script_custom') . '.jmx');
        $xml = new SimpleXMLElement($fileData);

        $resultThreads = $xml->xpath("/jmeterTestPlan/hashTree/hashTree/ThreadGroup/stringProp[@name='ThreadGroup.num_threads']");
        $resultThreads = $resultThreads[0];

        $resultIterations = $xml->xpath("/jmeterTestPlan/hashTree/hashTree/ThreadGroup/elementProp[@name='ThreadGroup.main_controller']/stringProp[@name='LoopController.loops']");
        $resultIterations = $resultIterations[0];

        $resultRampup = $xml->xpath("/jmeterTestPlan/hashTree/hashTree/ThreadGroup/stringProp[@name='ThreadGroup.ramp_time']");
        $resultRampup = $resultRampup[0];

        echo '<ul class="styled8">';

        $attr = $resultThreads->attributes();
        echo '<li>[' . $attr[0] . '] esta setado como [' . $resultThreads[0] . ']</li>';

        $attr = $resultIterations->attributes();
        echo '<li>[' . $attr[0] . '] esta setado como [' . $resultIterations[0] . ']</li>';

        $attr = $resultRampup->attributes();
        echo '<li>[' . $attr[0] . '] esta setado como [' . $resultRampup[0] . ']</li>';

        echo '</ul>';

        $result = $xml->xpath('/jmeterTestPlan/hashTree/TestPlan/elementProp/collectionProp/elementProp');

        if (count($result) > 0) {
            echo '<ul class="styled8">';
            foreach ($result as $node) {
                echo '<li>Variável [' . $node->stringProp[0] . '] com valor [' . $node->stringProp[1] . ']</li>';
            }
            echo '</ul>';
        }
    }

    public function actionDownloadjtl($id) {
        try {
            $client = new SoapClient(Yii::app()->params['jmeterServiceUrl'] . '/index.php?r=JmeterServer/service');
            $ret = $client->getJtlReport($id, Yii::app()->params['maxTriesToGenerateReport']);

            header("Content-Type: text/plain");
            header("Content-Length: " . strlen($ret));
            header("Content-Disposition: attachment; filename=" . basename('report_' . $id . '.jtl'));

            echo $ret;

            Yii::app()->end();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    private function startTestFlag() {
        Yii::app()->user->setState('running-test', true);
    }

    private function stopTestFlag() {
        Yii::app()->user->setState('running-test', false);
    }

    private function getTestFlag() {
        Yii::app()->user->getState('running-test');
    }

}
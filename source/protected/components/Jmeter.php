<?php

class Jmeter {

    public static function startTest($idTesteJMeter, $jmx, $email, $test = false) {

        $jmeterPath = Yii::app()->params['jmeterPath'];
        $jmeterRuntimePath = Yii::app()->basePath . '/runtime/jmeter';

        $jtlFile = $jmeterRuntimePath . '/test_' . $idTesteJMeter . '.jtl';
        $logFile = $jmeterRuntimePath . '/test_' . $idTesteJMeter . '.log';
        $reportFile = $jmeterRuntimePath . '/results_' . $idTesteJMeter . '.html';
        $jmxFile = $jmeterRuntimePath . '/' . $idTesteJMeter . '.jmx';
        $xslFile = Yii::app()->basePath . '/jmeter/report-template.xsl';

        if (!file_exists($jmeterRuntimePath)) {
            mkdir($jmeterRuntimePath);
        }

        // Create file
        if (file_exists($jmxFile))
            @unlink($jmxFile);

        file_put_contents($jmxFile, $jmx);

        $props = '';

        $props .= ' -Djmeter.save.saveservice.bytes=true';
        $props .= ' -Djmeter.save.saveservice.sample_count=true';
        $props .= ' -Djmeter.save.saveservice.thread_counts=true';
        $props .= ' -Djmeter.save.saveservice.thread_name=true';
        $props .= ' -Djmeter.save.saveservice.label=true';
        $props .= ' -Djmeter.save.saveservice.successful=true';
        $props .= ' -Djmeter.save.saveservice.response_code=true';
        $props .= ' -Djmeter.save.saveservice.response_message=true';
        $props .= ' -Djmeterthread.rampup.granularity=500';
        $props .= ' -Djmeter.save.saveservice.output_format=xml';
        // $props .= '-Djmeter.save.saveservice.response_data=true ';
        // $props .= ' -Djmeter.save.saveservice.response_data.on_error=true';
        $props .= ' -Djmeter.save.saveservice.time=true';

        @unlink($logFile);
        @unlink($jtlFile);

        // Limpa os processos
        exec('killall xslproc');
        exec('killall java');

        $command = $jmeterPath . '/bin/jmeter -n -t ' . $jmxFile . ' -j ' . $logFile . ' -l ' . $jtlFile . ' ' . $props;
        exec($command, $ar1);

        $commandReport = 'xsltproc ' . $xslFile . ' ' . $jtlFile . ' > ' . $reportFile;
        exec($commandReport, $ar2);

        // Enquanto não gerar o relatório fica parado
        while (!file_exists($reportFile)) {
            sleep(3);
        }

        // Envia e-mail de aviso que terminou
        $url = Yii::app()->params['baseUrl'] . '?r=jmeter/recoveryreportwithid&id=' . $idTesteJMeter;
        $name = 'Serviço de Testes do JMeter';
        $subject = '[JMeter] Teste Concluído (' . $idTesteJMeter . ')';
        $headers = "From: $name <noreply@taskmachine.com.br>\r\n" .
                "Reply-To: noreply@taskmachine.com.br\r\n" .
                "Bcc: " . Yii::app()->params['adminEmail'] . "\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-type: text/html; charset=UTF-8";

        // mail($email, $subject, 'Teste concluído [' . $idTesteJMeter . ']<br/><br/>Para ver o relatório acesse ' . $url . '<br/><br/>Atenciosamente, Equipe Performance Machine', $headers);

        return file_get_contents($reportFile);
    }

}

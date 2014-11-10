<?php
$this->pageTitle = Yii::app()->name;
?>
<script>
    $(document).ready(function() {
        $('#loading').hide();
        $('#step1').show();
        $('#step2').hide();
        $('#step3').hide();
    });
    
    function showHide(step) {
        switch(step) {
            case 1:
                $('#step1').show();
                $('#step2').hide();
                $('#step3').hide();
                break;
            case 2:
                $('#step1').hide();
                $('#step2').show();
                $('#step3').hide();
                showJmx();
                break;
            case 3:
                $('#step1').hide();
                $('#step2').hide();
                $('#step3').show();
                break;
        }
    }
    
    function showJmx() {
        $.post('<?php echo CController::createUrl('Jmeter/Viewjmx') ?>', function(data) {
            $("#jmx").html(data);
        }).error(function() { 
            alert('Erro ao carregar o JMX.')
        });
    }
    
    function finish(message) {
        /*if (message == 'error') {
            $("#data").html('Erro ao gerar o relatório. Utilize o ID do teste para solicitar o relatório mais tarde.');
        }*/
        
        $("#loading").hide(); 
        showHide(3);
    }
    
</script>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>Personalizado</h1>
            </header>
            <!-- END PAGE HEADING -->
        </div>
    </div>
</section>
<!-- END PAGE HEADING -->

<div id="content-wrapper">
    <section class="indent">
        <div class="container">
            <div class="grid_12">

                <h2>Envie Seu Teste Personalizado (ID: <span id="idTest"><?php echo Yii::app()->user->getState('script_custom') ?></span>)</h2>

                <br/>
                <br/>

                <div id="step1">
                    <h4 class="alt-title">Escolha o arquivo (JMX)</h4>

                    O arquivo JMX é o arquivo de script utilizado pela ferramenta JMeter, para maiores informações de como gravar um script leia o artigo <a href="http://juliancesar.com.br/j/2011/11/03/uso-do-jmeter-para-testes-de-performance-em-plataforma-web/" target="_blank">Uso do JMeter para Testes de Performance em Plataforma Web</a>.
                    <br/>
                    <br/>

                    <div id="upload" style="text-align: center;">
                        <?php
                        $this->widget('ext.EAjaxUpload.EAjaxUpload', array(
                            'id' => 'uploadFile',
                            'config' => array(
                                'action' => Yii::app()->createUrl('Jmeter/upload'),
                                'allowedExtensions' => array("jmx"),
                                'sizeLimit' => 1 * 1024 * 1024,
                                'onComplete' => "js:function(id, fileName, responseJSON){ showHide(2) }",
                                'messages' => array(
                                    'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
                                    'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
                                    'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
                                    'emptyError' => "{file} is empty, please select files again without it.",
                                    'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
                                ),
                                'showMessage' => "js:function(message){ alert(message); }"
                            ),
                        ));
                        ?>
                    </div>
                </div>

                <div id="step2">
                    <h4 class="alt-title">Inicie o teste</h4>

                    <h4>Dados do JMX</h4>
                    <div id="jmx" style="height: 200px; overflow-y: auto; margin-top: 15px;" class="grid_12">

                    </div>

                    <br/>

                    <script>                
                                    
                        var msgError = '<div style="text-align:center;"><b>Tempo limite para execução esgotado, tente recuperar o relatório mais tarde através do link <a href="<?php echo CController::createUrl('Jmeter/recoveryreport') ?>">Recuperar Relatório</a> e a identificação ' + $('#idTest').html() + '</b>.</div>';
                                    
                        $(document).ready(function() {
                            $("#sendTest").click(function() {                                
                                $.ajax({
                                    url:'<?php echo CController::createUrl('Jmeter/UpdateAjax') ?>',
                                    complete:function(XMLHttpRequest, textStatus){ finish(textStatus); },
                                    beforeSend:function(){ $("#sendTest").hide(); $("#loading").show(); },
                                    cache:false,
                                    success:function(html){ $("#data").html(html)},
                                    timeout:1000000000,
                                    type:'POST',
                                    error: function(jqXHR,error, errorThrown) {  
                                        jQuery("#data").html(msgError);
                                    },
                                });                                
                            });
                        });
                    </script>

                    <div style="text-align: center">
                        <input id="sendTest" class="pill" type="button" value="Iniciar o Teste de Performance" name="sendTest">
                    </div>

                    <style>
                        .ui-progressbar .ui-progressbar-value { background-image: url(themes/optimasale/style/images/pbar-ani.gif); }
                    </style>
                    <script>
                        $(function() {
                            $( "#progressbar" ).progressbar({
                                value: 100
                            });
                        }); 
                    </script>
                    <div id="loading">
                        Aguarde o teste ser executado...    

                        <br/><br/>
                        <div id="progressbar"></div>
                    </div>
                </div>

                <div id="step3">
                    <h4 class="alt-title">Relatório Final</h4>

                    <div id="data">
                        <?php $this->renderPartial('_ajaxContent', array('report' => $report)); ?>
                    </div>
                    <br/>
                    <div style="text-align: center;">
                        <a id="yw0" class="pill pill-style2" href="<?php echo CController::createUrl('Jmeter/index') ?>"><span class="pill-inner">Iniciar outro teste</span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
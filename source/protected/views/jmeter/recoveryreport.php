<?php
$this->pageTitle = Yii::app()->name . ' - Relatórios';
?>

<script>
    $(document).ready(function () {
        $('#report').hide(); 
        $("#loading").hide();
    });
    
    function validateAndSend() {
        if ($("#id").val() == "") {
            alert("Preencha o campo da identificação do relatório");
            return false;
        } else {                
            loading(true);
            return true;
        }
    }
    
    function loading(show) {
        if (show) {
            $('#form').hide();
            $('#report').hide();
            $('#loading').show();
        } else {
            $('#form').show();
            $('#report').show();
            $('#loading').hide();
        }
    }
    
</script>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>Relatórios</h1>
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
                <h2>Recuperação de Relatório</h2>

                <div style="text-align: center" class="grid_12" id="form">
                    <input id="id" style="display: inline;" class="grid_4" type="text" placeholder="Identificação do Teste">
                    <?php
                    echo CHtml::ajaxButton("Recuperar o Relatório", CController::createUrl('Jmeter/Recoveryreportcall'), array(
                        'update' => '#data',
                        'data' => array(
                            'id' => 'js:$("#id").val()',
                        ),
                        'beforeSend' => 'function(){ return validateAndSend(); }',
                        'complete' => 'function(){ loading(false); }',
                            ), array('class' => 'pill grid_4'));
                    ?>
                </div>


                <div id="loading">
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

                    Aguarde o relatório ser recuperado...    

                    <br/><br/>
                    <div id="progressbar"></div>
                </div>

                <br/><br/><br/><br/>

                <div id="report">
                    <h4 class="alt-title">Relatório Final</h4>

                    <br/>
                    <div id="data">
                        <?php $this->renderPartial('_ajaxContent', array('report' => $report)); ?>
                    </div>

                    <br/><br/>

                    <script>                
                        $(document).ready(function() {
                            $("#jtl").click(function() {                                
                                document.location.href="<?php echo CController::createUrl('Jmeter/Downloadjtl') ?>&id=" + $("#id").val();                             
                            });
                        });
                    </script>

                    <div style="text-align: center;">
                        <a class="pill pill-style2" href="<?php echo CController::createUrl('Jmeter/simple') ?>"><span class="pill-inner">Iniciar outro teste</span></a>
                        &nbsp;&nbsp;&nbsp;
                        <a class="pill pill-style2" id="jtl" href="#"><span class="pill-inner">Baixar dados brutos do JMeter (JTL)</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
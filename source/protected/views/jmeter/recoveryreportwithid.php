<?php
$this->pageTitle = Yii::app()->name . ' - Relatórios';
?>

<script>
    $(document).ready(function () {
        loading(true);
           
        jQuery.ajax({
            'data':{'id': '<?php echo $id ?>'},
            'complete':function(){ 
                loading(false); 
            },
            'url':'<?php echo CController::createUrl('Jmeter/Recoveryreportcall') ?>',
            'cache':false,
            'success':function(html){
                jQuery("#data").html(html)
            }
        });

    });
        
    function loading(show) {
        if (show) {
            $('#report').hide();
            $('#loading').show();
        } else {
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

                <br/>

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
                                document.location.href="<?php echo CController::createUrl('Jmeter/Downloadjtl') ?>&id=<?php echo $id ?>";                             
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
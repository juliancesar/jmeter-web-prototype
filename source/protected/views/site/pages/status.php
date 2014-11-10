<?php
$this->pageTitle = Yii::app()->name . ' - Servidores';
?>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>nossa infraestrutura</h1>
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
                <h1>Situação dos Servidores</h1>

                <p>Para a execução dos teste é necessária uma infraestrutura robusta e dinâmica. <br/><br/>Abaixo a situação de nossa infraestrutura para execução dos testes.</p>

                <div class="alert in alert-block fade alert-info" id="server-1">
                    Servidor 01 - <span class="status">Verificando...</span>
                </div>

                <script>
                    $(document).ready(function() {
                        $.post('<?php echo CController::createUrl('Jmeter/status') ?>', function() {
                            $("#server-1").removeClass("alert-info");
                            $("#server-1").addClass("alert-success");
                            $("#server-1 .status").html("Operacional");
                        }).error(function() { 
                            $("#server-1").removeClass("alert-info");
                            $("#server-1").addClass("alert-error");
                            $("#server-1 .status").html("Servidor indisponível");
                        });
                    });    
                </script>
            </div>
        </div>
    </section>
</div>
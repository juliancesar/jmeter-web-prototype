<?php
$this->pageTitle = Yii::app()->name;
?>
<script>
    $(document).ready(function() {
        $('#test-container').hide();
        $('#error-container').hide();
        $('#loading').hide();
        $('#step1').show();
        $('#step2').hide();
        $('#step3').hide();

        status();
    });

    function status() {
        $.post('<?php echo CController::createUrl('Jmeter/status') ?>', function() {
            $('#verify-container').hide();
            $('#test-container').show();
        }).error(function() {
            $('#verify-container').hide();
            $('#error-container').show();
        });
    }

    function showHide(step) {
        switch (step) {
            case 1:
                $('#step1').show();
                $('#step2').hide();
                $('#step3').hide();
                break;
            case 2:
                $('#step1').hide();
                $('#step2').show();
                $('#step3').hide();
                break;
            case 3:
                $('#step1').hide();
                $('#step2').hide();
                $('#step3').show();
                break;
        }
    }

    function validateAndSend() {
        if ($("#url").val() == "") {
            alert("Preencha o campo do domínio a ser testado");
            return false;
        } else {
            $("#step1").hide();
            $("#loading").show();

            return true;
        }
    }

</script>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>Simples</h1>
            </header>
            <!-- END PAGE HEADING -->
        </div>
    </div>
</section>
<!-- END PAGE HEADING -->

<div id="content-wrapper">
    <section class="indent">
        <div class="container" id="verify-container">
            <h1>Verificando disponibilidade dos servidores de teste...</h1>
        </div>
        <div class="container" id="error-container">
            <h1>Servidor Indisponível</h1>

            <p>Infelizmente o servidor de testes esta indisponível no momento, tente novamente mais tarde.</p>
        </div>
        <div class="container" id="test-container">
            <div class="grid_12">

                <h2>Execute Um Script Simples (ID: <span id="id-test"><?php echo Yii::app()->user->getState('script_simple') ?></span>)</h2>

                <br/>

                <div id="step1">
                    <h4 class="alt-title">Defina as informações do teste</h4>

                    <label>Seu e-mail</label>
                    <br/>

                    <p>As informações do teste serão enviadas para o seu e-mail, por isso precisamos que o campo abaixo seja preenchido.</p>

                    <input id="email" type="text" placeholder="seunome@dominio.com.br" class="grid_5">

                    <br/><br/><br/>

                    <label>Domínio do teste</label>
                    <br/>

                    http://
                    <input id="url" type="text" style="display: inline; width:300px;" placeholder="dominio.com.br">
                    /
                    <input id="path" type="text" style="display: inline; width:200px;" placeholder="caminho/da/aplicacao">


                    <br/><br/>

                    <!-- THREADS -->
                    <script>
                        $(function() {
                            $("#slider-threads").slider({
                                range: "max",
                                min: 1,
                                max: 20,
                                value: 5,
                                slide: function(event, ui) {
                                    $("#threads").html(ui.value);
                                }
                            });
                            $("#threads").html($("#slider-threads").slider("value"));
                        });
                    </script>

                    <label>Quantidade de usuários simultâneos</label>

                    <br/>
                    <span class="dropcap dropcap-style2" id="threads"></span>
                    <br/>
                    <div id="slider-threads" class="grid_8"></div>

                    <br/><br/>

                    <!-- DURATION -->
                    <script>
                        $(function() {
                            $("#slider-duration").slider({
                                range: "max",
                                min: 10,
                                max: 120,
                                step: 5,
                                value: 30,
                                slide: function(event, ui) {
                                    $("#duration").html(ui.value);
                                }
                            });
                            $("#duration").html($("#slider-duration").slider("value"));
                        });
                    </script>

                    <label>Duração total do teste em segundos</label>

                    <br/>
                    <span class="dropcap dropcap-style2" id="duration"></span>
                    <br/>
                    <div id="slider-duration" class="grid_8"></div>

                    <br/><br/>

                    <!-- TIMEOUT -->

                    <script>
                        $(function() {
                            $("#slider-timeout").slider({
                                range: "max",
                                min: 20,
                                step: 10,
                                max: 50,
                                value: 30,
                                slide: function(event, ui) {
                                    $("#timeout").html(ui.value);
                                }
                            });
                            $("#timeout").html($("#slider-timeout").slider("value"));
                        });
                    </script>

                    <label>Tempo máximo de espera para as requisições</label>

                    <br/>
                    <span class="dropcap dropcap-style2" id="timeout"></span>
                    <br/>
                    <div id="slider-timeout" class="grid_8"></div>

                    <br/><br/>
                    
                    <!-- RAMUP -->

                    <script>
                        $(function() {
                            $("#slider-rampup").slider({
                                range: "max",
                                min: 0,
                                max: 10,
                                value: 5,
                                slide: function(event, ui) {
                                    $("#rampup").html(ui.value);
                                }
                            });
                            $("#rampup").html($("#slider-rampup").slider("value"));
                        });
                    </script>

                    <label>Tempo de inicialização dos usuários (em segundos)</label>

                    <br/>
                    <span class="dropcap dropcap-style2" id="rampup"></span>
                    <br/>
                    <div id="slider-rampup" class="grid_8"></div>

                    <br/><br/>
                    
                    <!-- THINK TIME -->

                    <script>
                        $(function() {
                            $("#slider-thinktime").slider({
                                range: "max",
                                min: 100,
                                max: 900,
                                value: 500,
                                step: 50,
                                slide: function(event, ui) {
                                    $("#thinktime").html(ui.value);
                                }
                            });
                            $("#thinktime").html($("#slider-thinktime").slider("value"));
                        });
                    </script>

                    <label>Tempo de espera entre cada requisição do usuário (milliseconds)</label>

                    <br/>
                    <span class="dropcap dropcap-style2" id="thinktime"></span>
                    <br/>
                    <div id="slider-thinktime" class="grid_8"></div>

                    <br/><br/>

                    <!-- ASSERTION -->

                    <label>Texto que <b>deve</b> conter na resposta</label>
                    <div class="controls">
                        <input class="grid_7" id="assertion" type="text" placeholder=""> 
                    </div>
                    <br/><br/><br/>
                    <div style="text-align: center" class="grid_12">

                        <script>
                            var msgError = '<div style="text-align:center;"><b>Tempo limite para execução esgotado, tente recuperar o relatório mais tarde através do link <a href="<?php echo CController::createUrl('Jmeter/recoveryreport') ?>">Recuperar Relatório</a> e a identificação ' + $('#id-test').html() + '</b>.</div>';

                            jQuery(function($) {
                                jQuery('body').on('click', '#yt0', function() {
                                    jQuery.ajax({'timeout': 10000000000.,
                                        'data': {
                                            'url': $("#url").val(),
                                            'path': $("#path").val(),
                                            'threads': $("#threads").html(),
                                            'duration': $("#duration").html(),
                                            'timeout': $("#timeout").html(),
                                            'assertion': $("#assertion").val(),
                                            'email': $("#email").html(),
                                            'rampup': $("#rampup").html(),
                                            'thinktime': $("#thinktime").html()
                                        },
                                        'beforeSend': function() {
                                            return validateAndSend();
                                        },
                                        'complete': function() {
                                            $("#loading").hide();
                                            showHide(3);
                                        },
                                        'url': '<?php echo CController::createUrl('Jmeter/UpdateAjaxSimple') ?>',
                                        'cache': false,
                                        'error': function(jqXHR, error, errorThrown) {
                                            jQuery("#data").html(msgError);
                                        },
                                        'success': function(html) {
                                            jQuery("#data").html(html)
                                        }
                                    });
                                    return false;
                                });
                            });

                        </script>
                        <input id="yt0" class="pill" type="button" value="Iniciar o Teste de Performance" name="yt0">
                    </div>
                </div>

                <style>
                    .ui-progressbar .ui-progressbar-value { background-image: url(themes/optimasale/style/images/pbar-ani.gif); }
                </style>
                <script>
                    $(function() {
                        $("#progressbar").progressbar({
                            value: 100
                        });
                    });
                </script>
                <div id="loading">
                    Aguarde o teste ser executado...    

                    <br/><br/>
                    <div id="progressbar"></div>
                </div>

                <div id="step3">
                    <h4 class="alt-title">Relatório Final</h4>

                    <div id="data">
                        <?php $this->renderPartial('_ajaxContent', array('report' => $report)); ?>
                    </div>

                    <br/>

                    <div style="text-align: center;">
                        <a id="yw0" class="pill pill-style2" href="<?php echo CController::createUrl('Jmeter/simple') ?>"><span class="pill-inner">Iniciar outro teste</span></a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
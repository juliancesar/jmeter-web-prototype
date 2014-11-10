<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform" 
                xmlns:date="http://exslt.org/dates-and-times" 
                xmlns:str="http://exslt.org/strings" 
                xmlns:func="http://exslt.org/functions" 
                xmlns:exsl="http://exslt.org/common"
                extension-element-prefixes="date str func exsl">
    
    <xsl:import href="./date.format-date.function.xsl" />
    <xsl:output method="html" indent="yes" encoding="UTF-8" doctype-public="-//W3C//DTD HTML 4.01 Transitional//EN" />
    <xsl:param name="dateReport" select="'dado não definido'"/>

    <xsl:template match="testResults">
        <html>
            <head>
                <style type="text/css">
                    
                    table tr td, table tr th {
                        font-size: 90%;
                    }
                    table.details tr th{
                        color: #ffffff;
                        font-weight: bold;
                        text-align: center;
                        background:#2674a6;
                    }
                    table.details tr td{
                        background:#eeeee0;
                        text-align: center;
                    }
                    .Failure {
                        font-weight:bold; 
                        /*color:red;*/
                    }
                    
                    img
                    {
                        border-width: 0px;
                    }
				
                    .expand_link
                    {
                        position:absolute;
                        right: 0px;
                        width: 27px;
                        top: 1px;
                        height: 27px;
                    }
				
                    .page_details
                    {
                        display: none;
                    }                   

                </style>
            </head>
            <body>	
                <xsl:call-template name="display-graphs" />
                	
                <xsl:call-template name="summary" />
                <hr size="1" width="95%" align="center" />
			
                <xsl:call-template name="pagelist" />
                <hr size="1" width="95%" align="center" />
			
                <xsl:call-template name="detail" />
            </body>
        </html>
    </xsl:template>

    <xsl:template name="summary">
        <h3>Resumo</h3>
        
        <xsl:variable name="minDateTime">
            <xsl:call-template name="min">
                <xsl:with-param name="nodes" select="/testResults/*/@ts" />
            </xsl:call-template>
        </xsl:variable>
        <xsl:variable name="maxDateTime">
            <xsl:call-template name="max">
                <xsl:with-param name="nodes" select="/testResults/*/@ts" />
            </xsl:call-template>
        </xsl:variable>   
        
        <p>
            Início:
            <strong>
                <xsl:call-template name="display-date-time">
                    <xsl:with-param name="value" select="$minDateTime" />
                </xsl:call-template>
            </strong>  
            Fim: 
            <strong>
                <xsl:call-template name="display-date-time">
                    <xsl:with-param name="value" select="$maxDateTime" />
                </xsl:call-template>
            </strong>              
            Duração: 
            <strong>
                <span id="total-seconds"><xsl:value-of select="ceiling(($maxDateTime - $minDateTime) div 1000)" /></span> segundos
            </strong>
        </p>            
        
        <table align="center" class="details" border="0" cellpadding="5" cellspacing="2" width="95%">
            <tr valign="top">
                <th>Amostras</th>
                <th>Falhas</th>
                <th>Taxa de Sucesso</th>
                <th>Tempo Médio</th>
                <th>Tempo Mínimo</th>
                <th>Tempo Máximo</th>
            </tr>
            <tr valign="top">
                <xsl:variable name="allCount" select="count(/testResults/*)" />
                <xsl:variable name="allFailureCount" select="count(/testResults/*[attribute::s='false'])" />
                <xsl:variable name="allSuccessCount" select="count(/testResults/*[attribute::s='true'])" />
                <xsl:variable name="allSuccessPercent" select="$allSuccessCount div $allCount" />
                <xsl:variable name="allTotalTime" select="sum(/testResults/*/@t)" />
                <xsl:variable name="allAverageTime" select="$allTotalTime div $allCount" />
                <xsl:variable name="allMinTime">
                    <xsl:call-template name="min">
                        <xsl:with-param name="nodes" select="/testResults/*/@t" />
                    </xsl:call-template>
                </xsl:variable>
                <xsl:variable name="allMaxTime">
                    <xsl:call-template name="max">
                        <xsl:with-param name="nodes" select="/testResults/*/@t" />
                    </xsl:call-template>
                </xsl:variable>             
                <xsl:attribute name="class">
                    <xsl:choose>
                        <xsl:when test="$allFailureCount &gt; 0">Failure</xsl:when>
                    </xsl:choose>
                </xsl:attribute>
                <td align="center" id="total-samples">
                    <xsl:value-of select="$allCount" />
                </td>
                <td align="center">
                    <xsl:value-of select="$allFailureCount" />
                </td>
                <td align="center">
                    <xsl:call-template name="display-percent">
                        <xsl:with-param name="value" select="$allSuccessPercent" />
                    </xsl:call-template>
                </td>
                <td align="center">
                    <xsl:call-template name="display-time">
                        <xsl:with-param name="value" select="$allAverageTime" />
                    </xsl:call-template>
                </td>
                <td align="center">
                    <xsl:call-template name="display-time">
                        <xsl:with-param name="value" select="$allMinTime" />
                    </xsl:call-template>
                </td>
                <td align="center">
                    <xsl:call-template name="display-time">
                        <xsl:with-param name="value" select="$allMaxTime" />
                    </xsl:call-template>
                </td>
            </tr>
        </table>
    </xsl:template>

    <xsl:template name="pagelist">
        <h3>Páginas</h3>
        <table align="center" class="details" border="0" cellpadding="3" cellspacing="2" width="95%">
            <tr valign="top">
                <th>URL</th>
                <th>Amostras</th>
                <th>Falhas</th>
                <th>Taxa de Sucesso</th>
                <th>Tempo Médio</th>
                <th>Tempo Mínimo</th>
                <th>Tempo Máximo</th>
                <th></th>
            </tr>
            <xsl:for-each select="/testResults/*[not(@lb = preceding::*/@lb)]">
                <xsl:variable name="label" select="@lb" />
                <xsl:variable name="count" select="count(../*[@lb = current()/@lb])" />
                <xsl:variable name="failureCount" select="count(../*[@lb = current()/@lb][attribute::s='false'])" />
                <xsl:variable name="successCount" select="count(../*[@lb = current()/@lb][attribute::s='true'])" />
                <xsl:variable name="successPercent" select="$successCount div $count" />
                <xsl:variable name="totalTime" select="sum(../*[@lb = current()/@lb]/@t)" />
                <xsl:variable name="averageTime" select="$totalTime div $count" />
                <xsl:variable name="minTime">
                    <xsl:call-template name="min">
                        <xsl:with-param name="nodes" select="../*[@lb = current()/@lb]/@t" />
                    </xsl:call-template>
                </xsl:variable>
                <xsl:variable name="maxTime">
                    <xsl:call-template name="max">
                        <xsl:with-param name="nodes" select="../*[@lb = current()/@lb]/@t" />
                    </xsl:call-template>
                </xsl:variable>
                <tr valign="top">
                    <xsl:attribute name="class">
                        <xsl:choose>
                            <xsl:when test="$failureCount &gt; 0">Failure</xsl:when>
                        </xsl:choose>
                    </xsl:attribute>
                    <td>
                        <xsl:if test="$failureCount > 0">
                            <a>
                                <xsl:attribute name="href">#<xsl:value-of select="$label" /></xsl:attribute>
                                <xsl:value-of select="$label" />
                            </a>
                        </xsl:if>
                        <xsl:if test="0 >= $failureCount">
                            <xsl:value-of select="$label" />
                        </xsl:if>
                    </td>
                    <td align="center">
                        <xsl:value-of select="$count" />
                    </td>
                    <td align="center">
                        <xsl:value-of select="$failureCount" />
                    </td>
                    <td align="right">
                        <xsl:call-template name="display-percent">
                            <xsl:with-param name="value" select="$successPercent" />
                        </xsl:call-template>
                    </td>
                    <td align="right">
                        <xsl:call-template name="display-time">
                            <xsl:with-param name="value" select="$averageTime" />
                        </xsl:call-template>
                    </td>
                    <td align="right">
                        <xsl:call-template name="display-time">
                            <xsl:with-param name="value" select="$minTime" />
                        </xsl:call-template>
                    </td>
                    <td align="right">
                        <xsl:call-template name="display-time">
                            <xsl:with-param name="value" select="$maxTime" />
                        </xsl:call-template>
                    </td>
                    <td align="center">
                        <a href="" onclick="">
                            <xsl:attribute name="href">
                                <xsl:text/>#page_details_<xsl:value-of select="position()" />
                            </xsl:attribute>
                            <xsl:attribute name="onclick">
                                <xsl:text/>javascript:jQuery('#page_details_<xsl:value-of select="position()" />').toggle();
                            </xsl:attribute>Detalhes
                        </a>
                    </td>
                </tr>
			
                <tr class="page_details">
                    <xsl:attribute name="id">
                        <xsl:text/>page_details_<xsl:value-of select="position()" />
                    </xsl:attribute>
                    <td colspan="8" bgcolor="#FF0000">
                        <div align="center">
                            <b>Detalhes da Página "
                                <xsl:value-of select="$label" />"
                            </b>
                            <table bordercolor="#000000" bgcolor="#2674A6" border="0"  cellpadding="1" cellspacing="1" width="95%">
                                <tr>
                                    <th>Usuário</th>
                                    <th>Data/Hora</th>
                                    <th>Usuários Simultâneos</th>
                                    <th>Iteração</th>
                                    <th>Tempo (ms)</th>
                                    <th>Bytes</th>
                                    <th>Requisições Embutidas</th>
                                    <th>Sucesso</th>
                                </tr>
			         		         
                                <xsl:for-each select="../*[@lb = $label and @tn != $label]">		
                                    
                                    <!--<xsl:sort select="@ts" data-type="number" />                                    -->
                                    
                                    <xsl:variable name="contEmbedded" select="count(current()/httpSample)" />
                                    <tr>
                                        <td>
                                            <xsl:value-of select="@tn" />
                                        </td>                                        
                                        <td>
                                            <xsl:call-template name="display-date-time">
                                                <xsl:with-param name="value" select="@ts" />
                                            </xsl:call-template>                                         
                                        </td>
                                        <td>
                                            <xsl:value-of select="@ng" />
                                        </td>
                                        <td align="center">
                                            <xsl:value-of select="position()" />
                                        </td>
                                        <td align="right">
                                            <xsl:value-of select="@t" />
                                        </td>
                                        <!--  TODO allow for missing bytes field -->
                                        <td align="right">
                                            <xsl:value-of select="@by" />
                                        </td>
                                        <td align="right" class="total-embedded">
                                            <xsl:value-of select="$contEmbedded" />
                                        </td>
                                        <td align="center">
                                            <xsl:if test="@s = 'true'">
                                                Sim
                                            </xsl:if>
                                            <xsl:if test="@s = 'false'">
                                                Não
                                            </xsl:if>
                                        </td>
                                    </tr>
                                </xsl:for-each>
			         
                            </table>
                        </div>
                    </td>
                </tr>			
            </xsl:for-each>
        </table>
    </xsl:template>

    <xsl:template name="detail">
        <xsl:variable name="allFailureCount" select="count(/testResults/*[attribute::s='false'])" />

        <xsl:if test="$allFailureCount > 0">
            <h3>Detalhes da Falha</h3>

            <xsl:for-each select="/testResults/*[not(@lb = preceding::*/@lb)]">

                <xsl:variable name="failureCount" select="count(../*[@lb = current()/@lb][attribute::s='false'])" />

                <xsl:if test="$failureCount > 0">
                    <h4>
                        <xsl:value-of select="@lb" />
                        <a>
                            <xsl:attribute name="name">
                                <xsl:value-of select="@lb" />
                            </xsl:attribute>
                        </a>
                    </h4>

                    <table align="center" class="details" border="0" cellpadding="5" cellspacing="2" width="95%">
                        <tr valign="top">
                            <th>Resposta do Servidor</th>
                            <th>Mensagem de Falha</th>
                        </tr>
			
                        <xsl:for-each select="/testResults/*[@lb = current()/@lb][attribute::s='false']">
                            <tr>
                                <td>
                                    <xsl:value-of select="@rc | @rs" /> - 
                                    <xsl:value-of select="@rm" />
                                </td>
                                <td>
                                    <xsl:value-of select="assertionResult/failureMessage" />
                                </td>
                            </tr>
                        </xsl:for-each>
				
                    </table>
                </xsl:if>

            </xsl:for-each>
        </xsl:if>
    </xsl:template>

    <xsl:template name="min">
        <xsl:param name="nodes" select="/.." />
        <xsl:choose>
            <xsl:when test="not($nodes)">NaN</xsl:when>
            <xsl:otherwise>
                <xsl:for-each select="$nodes">
                    <xsl:sort data-type="number" />
                    <xsl:if test="position() = 1">
                        <xsl:value-of select="number(.)" />
                    </xsl:if>
                </xsl:for-each>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template name="max">
        <xsl:param name="nodes" select="/.." />
        <xsl:choose>
            <xsl:when test="not($nodes)">NaN</xsl:when>
            <xsl:otherwise>
                <xsl:for-each select="$nodes">
                    <xsl:sort data-type="number" order="descending" />
                    <xsl:if test="position() = 1">
                        <xsl:value-of select="number(.)" />
                    </xsl:if>
                </xsl:for-each>
            </xsl:otherwise>
        </xsl:choose>
    </xsl:template>

    <xsl:template name="display-percent">
        <xsl:param name="value" />
        <xsl:value-of select="format-number($value,'0.00%')" />
    </xsl:template>

    <xsl:template name="display-time">
        <xsl:param name="value" />
        <xsl:value-of select="format-number($value,'0 ms')" />
    </xsl:template>   
	
    <xsl:template name="display-date-time">
        <xsl:param name="value" />
        <xsl:value-of select="date:format-date(date:add(date:add('1970-01-01T00:00:00Z', date:duration($value div 1000)), date:duration(180 * 1000 * -1)), 'dd/MM/yy HH:mm:ss')" />
    </xsl:template>

    <xsl:template name="display-date-time-pattern">
        <xsl:param name="value" />
        <xsl:param name="pattern" />
        <xsl:value-of select="date:format-date(date:add(date:add('1970-01-01T00:00:00Z', date:duration($value div 1000)), date:duration(180 * 1000 * -1)), $pattern)" />
    </xsl:template>
    
    
    <xsl:template name="display-graphs">
        <!-- 
        
        Gerar um gráfico que tenha o número de usuários ativos por segundo...
        
        1. Listar ordenando por tempo
        2. Só mostrar quando?
            2.1. A data for diferente da anterior
            2.2. OU o número de usuários for maior (FURADO: vai mostrar 2 vezes a mesma hora(
        
        1. Listar sem ordenar (FURADO: TEM QUE ORDENAR!)
        2. Mostra somente se o registro anterior for maior que o anterior
        
        -->
        
<!--        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script language="javascript" type="text/javascript" src="chart/flot/jquery.flot.js"></script>
        <script language="javascript" type="text/javascript" src="chart/flot/jquery.flot.time.js"></script>
        
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>-->
        
        <script type="text/javascript">      
            // Docs: https://github.com/flot/flot/blob/master/API.md
            
            jQuery(document).ready(function () {

                var data = [<xsl:for-each select="/testResults/*"><xsl:sort select="@ts" data-type="number" />[<xsl:value-of select="@ts" />,[<xsl:value-of select="@na" />,<xsl:value-of select="@t" />,<xsl:value-of select="@s" />]],</xsl:for-each>];                
                
                Highcharts.setOptions({
                    global: {
                        useUTC: false
                    }
                });

                var times = [];
                var dataFinal = [];
                var dataFinalMs = [];
                var dataFinalMsMinor = [];
                var dataFinalError = [];
                var dataFinalReqs = [];

                var second = {};
                $.each(data, function(key, val) {
                    var auxTime = Math.round(val[0] / 1000);
                    if (!second[auxTime]) {

                        var countError = 0;
                        if (!val[1][2]) {
                            countError = 1;
                        }

                        second[auxTime] = [val[1][0], val[1][1], countError, val[1][1], 1];
                    } else {
                        if (!val[1][2])
                            second[auxTime][2] = second[auxTime][2] + 1;

                        if (val[1][0] > second[auxTime][0])
                            second[auxTime][0] = val[1][0];

                        if (val[1][1] > second[auxTime][1])
                            second[auxTime][1] = val[1][1];

                        if (second[auxTime][3] > val[1][1])
                            second[auxTime][3] = val[1][1];

                        // Número de reqs
                        second[auxTime][4] = second[auxTime][4] + 1;
                    }

                });

                var ant = 0;
                $.each(second, function(key, val) {

                    if (ant == 0)
                        ant = key;

                    // Preenche os espaços vazios
                    var diff = key - ant;

                    if (diff > 1) {
                        diff--;
                        for (i = 0; diff > i; i++) {

                            ant++;

                            times.push(0);
                            dataFinal.push(val[0]);
                            dataFinalMs.push(0);
                            dataFinalMsMinor.push(0);
                            dataFinalError.push(0);
                            dataFinalReqs.push(0);
                        }
                    }

                    times.push(parseInt(key) * 1000);
                    dataFinal.push(val[0]);
                    dataFinalMs.push(val[1] / 1000);
                    dataFinalMsMinor.push(val[3] / 1000);
                    dataFinalError.push(val[2]);
                    dataFinalReqs.push(val[4]);

                    ant = key;
                });

                var intervalAux = Math.round(times.length / 10) + 2;

                console.log(intervalAux);

                // Hightcharts
                $('#chart-time-new').highcharts({
                    title: {
                        text: 'Compilações das Informações do Teste'
                    },
                    xAxis: {
                        type: 'datetime',
                    },
                    yAxis: [{
                            // Secondary yAxis
                            title: {
                                text: 'Maior Tempo de Resposta',
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            labels: {
                                format: '{value} s',
                                style: {
                                    color: '#4572A7'
                                }
                            },
                            min: 0,
                            maxPadding: 0.01,
                        },
                        {
                            // yAxis
                            title: {
                                text: 'Menor Tempo de Resposta',
                                style: {
                                    color: '#666'
                                }
                            },
                            labels: {
                                format: '{value} s',
                                style: {
                                    color: '#666'
                                }
                            },
                            min: 0,
                            maxPadding: 0.01,
                        },
                        {
                            // Primary yAxis
                            labels: {
                                format: '{value}',
                                style: {
                                    color: '#89A54E'
                                }
                            },
                            title: {
                                text: 'Usuários Simulâneos',
                                style: {
                                    color: '#89A54E'
                                }
                            },
                            min: 0,
                            opposite: true,
                            maxPadding: 0.01,
                        },
                        {
                            // yAxis
                            title: {
                                text: 'Número de Requisições',
                                style: {
                                    color: '#FFCC00'
                                }
                            },
                            labels: {
                                format: '{value}',
                                style: {
                                    color: '#FFCC00'
                                }
                            },
                            min: 0,
                            opposite: true,
                            maxPadding: 0.01,
                        },
                        {
                            // yAxis
                            title: {
                                text: 'Erros',
                                style: {
                                    color: '#FF0000'
                                }
                            },
                            labels: {
                                format: '{value}',
                                style: {
                                    color: '#FF0000'
                                }
                            },
                            opposite: true,
                            min: 0,
                            maxPadding: 0.01,
                        },
                    ],
                    tooltip: {
                        shared: true,
                        xDateFormat: "%d/%m/%y %H:%M:%S",
                    },
                    plotOptions: {
                        line: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 3
                                }
                            },
                            marker: {
                                enabled: false
                            },
                        },
                    },
                    series: [{
                            yAxis: 0,
                            name: 'Maior Tempo de Resposta',
                            color: '#4572A7',
                            type: 'line',
                            dataGrouping: {
                                enabled: false
                            },
                            data: dataFinalMs,
                            tooltip: {
                                valueSuffix: ' segundos'
                            },
                            pointStart: times[0],
                            pointInterval : 1000
                        }
                        , {
                            yAxis: 0,
                            name: 'Menor Tempo de Resposta',
                            color: '#666',
                            type: 'line',
                            data: dataFinalMsMinor,
                            tooltip: {
                                valueSuffix: ' segundos'
                            },
                            pointStart: times[0],
                            pointInterval : 1000
                        }
                        , {
                            yAxis: 2,
                            name: 'Usuário Simultâneos',
                            color: '#89A54E',
                            type: 'line',
                            data: dataFinal,
                            tooltip: {
                                valueSuffix: ' usuários'
                            },
                            pointStart: times[0],
                            pointInterval : 1000
                        }
                        , {
                            yAxis: 2,
                            name: 'Requisições',
                            color: '#FFCC00',
                            type: 'line',
                            data: dataFinalReqs,
                            tooltip: {
                                valueSuffix: ' requisições'
                            },
                            pointStart: times[0],
                            pointInterval : 1000
                        }
                        , {
                            yAxis: 2,
                            name: 'Errors',
                            color: '#FF0000',
                            type: 'line',
                            data: dataFinalError,
                            tooltip: {
                                valueSuffix: ' erros'
                            },
                            pointStart: times[0],
                            pointInterval : 1000
                        }
                    ]
                });

            });

        </script>
        
        <div id="chart-time-new" style="width: 930px; height: 350px;"></div>
        
        <br/>
        <br/>
      
    </xsl:template>
        
</xsl:stylesheet>

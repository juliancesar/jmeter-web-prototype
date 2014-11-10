<?php
Yii::app()->clientScript->scriptMap = array(
    'jquery.js' => false,
);
?>
<!DOCTYPE html>
    <!--[if IE 7]>                  <html class="ie7 no-js" lang="en">     <![endif]-->
    <!--[if lte IE 8]>              <html class="ie8 no-js" lang="en">     <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!--> <html class="not-ie no-js" lang="en">  <!--<![endif]-->
    <head>

        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <?php
        $cs = Yii::app()->clientScript;

        // ----------------------------------- CSS -----------------------------------
        $cs->registerCssFile('themes/optimasale/style/css/normalize.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/fonts.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/skeleton.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/base.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/superfish.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/style.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/prettyPhoto.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/flexslider.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/layout.css', 'screen');
        $cs->registerCssFile('themes/optimasale/style/css/jquery-ui.css');

        $cs->registerCssFile('theme/optimasale/style/css/ie/ie8.css', 'lte IE 9');

        $cs->registerCssFile('http://html5shim.googlecode.com/svn/trunk/html5.js', 'lt IE 9');
        
        ?>

        <link rel="shortcut icon" href="themes/optimasale/style/images/favicon.ico">
        <link rel="apple-touch-icon" href="themes/optimasale/style/images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="themes/optimasale/style/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="themes/optimasale/style/images/apple-touch-icon-114x114.png">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css' />
        <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
        
        <?php
        // ----------------------------------- JAVASCRIPT ----------------------------------- 
        $position = CClientScript::POS_HEAD;

        $cs->registerScriptFile('js/jquery.ba-bbq-1.4pre.min.js', $position);
        $cs->registerScriptFile('js/jquery.maskedinput-1.3.1.min.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery-1.8.1.min.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/modernizr.custom.14583.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/superfish.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.easing.min.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.prettyPhoto.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.mobilemenu.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.elastislide.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.checkbox.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.flexslider.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery.reveal.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/custom.js', $position);
        $cs->registerScriptFile('themes/optimasale/style/js/jquery-ui.js', $position);
        $cs->registerScriptFile('chart/flot/jquery.flot.js', $position);
        $cs->registerScriptFile('chart/flot/jquery.flot.time.js', $position);
        $cs->registerScriptFile('chart/highcharts/js/highcharts.js', $position);
        $cs->registerScriptFile('chart/highcharts/js/modules/exporting.js', $position);
        ?>

        <!--[if lt IE 8]>
        <div style=' clear: both; text-align:center; position: relative;'>
                <a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
        </div>
        <![endif]-->


        <script>
            (function(i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function() {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-40748084-1', 'perfmachine.com.br');
            ga('send', 'pageview');
        </script>

    </head>
    <body class="page home-page">

        <!-- Primary Page Layout
        ================================================== -->

        <!-- BEGIN WRAPPER -->
        <div id="wrapper">


            <!-- BEGIN HEADER -->
            <header id="header">

                <!--Main Header-->
                <div id="main-header">
                    <div class="container">
                        <div class="grid_12">

                            <!-- BEGIN LOGO -->
                            <div id="logo">
                                <!-- Image based Logo-->
                                <!--<a href="index-2.html"><img src="themes/optimasale/style/images/logo.png" alt=""/></a>-->

                                <h1><a href="<?php echo CController::createUrl('Site/index') ?>"><span>Performance</span>Machine</a></h1>
                                <p class="tagline">testes de performance</p>
                            </div>
                            <!-- END LOGO -->

                            <!-- BEGIN NAVIGATION -->
                            <nav class="primary">
                                <ul class="sf-menu">
                                    <li <?php if ($this->id == 'site' && $this->action->id == 'index') echo 'class="current-menu-item"'; ?>><a href="<?php echo CController::createUrl('Site/index') ?>">home</a></li>                                    

                                    <?php if (false) : ?>
                                        <li <?php if ($this->id == 'site' && CHttpRequest::getParam('view') == 'services') echo 'class="current-menu-item"'; ?>><a href="<?php echo CController::createUrl('Site/page', array('view' => 'services')) ?>">serviços</a></li>
                                    <?php endif; ?>

                                    <li <?php if ($this->id == 'site' && CHttpRequest::getParam('view') == 'about') echo 'class="current-menu-item"'; ?>><a href="<?php echo CController::createUrl('Site/page', array('view' => 'about')) ?>">sobre</a></li>
                                    <li <?php if ($this->id == 'site' && CHttpRequest::getParam('view') == 'contact') echo 'class="current-menu-item"'; ?>><a href="<?php echo CController::createUrl('Site/contact') ?>">contato</a></li>
                                </ul>
                            </nav>
                            <!-- END NAVIGATION -->

                        </div>
                    </div>
                </div>

            </header>
            <!-- END HEADER -->

            <?php echo $content; ?>

            <!-- BEGIN WIDGETS -->
            <section id="widgets">
                <div class="indent">
                    <div class="container">

                        <div class="grid_4">
                            <!-- BEGIN NAV Widget -->
                            <div class="widget widget-nav">
                                <h4>Páginas</h4>
                                <ul>
                                    <li><a href="<?php echo CController::createUrl('Site/index') ?>">Home</a></li>
                                    <!--
                                    <li><a href="<?php echo CController::createUrl('Site/page', array('view' => 'services')) ?>">Serviços</a></li>
                                    -->
                                    <li><a href="<?php echo CController::createUrl('Site/page', array('view' => 'about')) ?>">Sobre</a></li>
                                    <li><a href="<?php echo CController::createUrl('Jmeter/simple') ?>">Demonstração Simples</a></li>
                                    <li><a href="<?php echo CController::createUrl('Site/contact') ?>">Contato</a></li>
                                </ul>
                            </div>
                            <!-- END NAV Widget -->
                        </div>
                        
                    </div>
                </div>
            </section>
            <!-- END WIDGETS -->


            <!-- BEGIN FOOTER -->
            <footer id="footer">
                <div class="container">
                    <div class="grid_12">
                        <small>&copy;<?php echo date("Y") ?> Performance Machine. Todos os direitos reservados.</small> <a href="<?php echo CController::createUrl('Site/page', array('view' => 'privacy')) ?>">Política de Privacidade</a> &nbsp; <a href="<?php echo CController::createUrl('Site/page', array('view' => 'terms')) ?>">Termos de Serviço</a>
                    </div>
                </div>
            </footer>
            <!-- END FOOTER -->
        </div>
        <!-- END WRAPPER -->


        <!-- Flexslider Init -->
        <script type="text/javascript">

            $(window).load(function() {
                $('.flexslider').flexslider({
                    animation: "fade",
                    controlNav: false,
                    // Callback API
                    before: function() {
                    },
                    after: function() {
                    },
                    start: function(slider) {
                        $('#slider').removeClass('loading');
                    }
                });
            });

        </script>

    </body>
</html>
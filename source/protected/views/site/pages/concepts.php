<?php
$this->pageTitle = Yii::app()->name . ' - Conceitos';
?>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>como funcionam as coisas</h1>
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
                <h2>Conceitos</h2>
                <p><b>Concorrentes</b></p>

                <p>Usuários com conexões ativas na aplicação, ou seja, a soma de todos os usuários que estão executando qualquer caso de teste dentro do sistema para um intervalo de tempo definido.</p>

                <p><b>Simultâneos</b></p>

                <p>Usuários com execuções/requisições em tempos idênticos (ex.: soma de usuários executando o mesmo cenário, com as mesmas requisições ao mesmo tempo). Nesta definição, seriam considerados usuários simultâneos apenas aqueles usuários que estiverem executando o mesmo caso de teste ao mesmo tempo.</p>
            </div>
        </div>
    </section>
</div>
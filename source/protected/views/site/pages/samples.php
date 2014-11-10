<?php
$this->pageTitle = Yii::app()->name . ' - Exemplos';
?>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>Experimente</h1>
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
                <h1>Exemplos de Relatórios</h1>

                <ul>
                    <?php foreach (Recent::model()->list()->findAll() as $recent) : ?>
                        <li><a href="<?php echo CController::createUrl('jmeter/recoveryreportwithid', array('id' => $recent->id)) ?>">Acesso a <b><?php echo $recent->url ?></b></a></li>
                    <?php endforeach; ?>
                </ul>

            </div>
        </div>
    </section>
</div>
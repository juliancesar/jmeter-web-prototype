<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = Yii::app()->name . ' - Error';
$this->breadcrumbs = array(
    'Error',
);
?>

<!-- BEGIN PAGE HEADING -->
<section id="heading">

    <div class="container">

        <div class="grid_8">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>ooops!!! erro</h1>
            </header>
            <!-- END PAGE HEADING -->
        </div>

    </div>

</section>
<!-- END PAGE HEADING -->



<!-- BEGIN CONTENT HOLDER -->
<div id="content-wrapper">

    <section class="indent">

        <!-- BEGIN 404 WRAPPER -->
        <div id="error404" class="container">
            <div class="error404-num hide-text grid_4">
                404
            </div>
            <div class="grid_7 prefix_1">
                <hgroup>
                    <h2><?php echo CHtml::encode($message); ?></h2>
                </hgroup>
            </div>
        </div>
        <!-- END 404 WRAPPER -->

    </section>

</div>
<!-- END CONTENT HOLDER -->
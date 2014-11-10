<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle = Yii::app()->name . ' - Contato';
?>

<!-- BEGIN PAGE HEADING -->
<section id="heading">
    <div class="container">
        <div class="grid_12">
            <!-- BEGIN PAGE HEADING -->
            <header class="page-heading">
                <h1>contato</h1>
            </header>
            <!-- END PAGE HEADING -->
        </div>
    </div>
</section>
<!-- END PAGE HEADING -->

<br/>
<br/>

<div class="indent">

    <div class="container">
        <div class="grid_12">
            <div class="map-wrapper">

                <div style="padding: 20px;">

                    <h3>
                        Envie uma mensagem para nós, e assim que for possível entraremos em contato.
                    </h3>

                    <br/>

                    <?php if (Yii::app()->user->hasFlash('contact')): ?>

                        <div class="alert alert-success nomargin">
                            <?php echo Yii::app()->user->getFlash('contact'); ?>
                        </div>

                    <?php else: ?>

                        <div class="form">

                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'contact-form',
                                'enableClientValidation' => false,
                                'clientOptions' => array(
                                    'validateOnSubmit' => false,
                                ),
                                    ));
                            ?>

                            <p class="note">Preencha os campos marcados com <span class="required">*</span>.</p>

                            <?php if ($model->hasErrors()) : ?>
                                <div class="alert alert-error">
                                    <?php echo $form->errorSummary($model); ?>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <?php echo $form->labelEx($model, 'name'); ?>
                                <?php echo $form->textField($model, 'name', array('class' => 'input-big')); ?>
                                <?php echo $form->error($model, 'name'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model, 'email'); ?>
                                <?php echo $form->textField($model, 'email', array('class' => 'input-big')); ?>
                                <?php echo $form->error($model, 'email'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model, 'subject'); ?>
                                <?php echo $form->textField($model, 'subject', array('size' => 60, 'maxlength' => 128, 'class' => 'input-big')); ?>
                                <?php echo $form->error($model, 'subject'); ?>
                            </div>

                            <div class="row">
                                <?php echo $form->labelEx($model, 'body'); ?>
                                <?php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50, 'class' => 'input-big')); ?>
                                <?php echo $form->error($model, 'body'); ?>
                            </div>

                            <?php if (CCaptcha::checkRequirements()): ?>
                                <div class="row">
                                    <?php echo $form->labelEx($model, 'verifyCode'); ?>
                                    <div>
                                        <?php $this->widget('CCaptcha'); ?>
                                        <?php echo $form->textField($model, 'verifyCode', array('class' => 'input-small')); ?>
                                    </div>
                                    <div class="hint">Por favor, informe as letras exibidas acima.</div>
                                    <?php echo $form->error($model, 'verifyCode'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="row buttons">
                                <?php echo CHtml::submitButton('Enviar Mensagem'); ?>
                            </div>

                            <?php $this->endWidget(); ?>

                        </div><!-- form -->

                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="clearfix"></div>




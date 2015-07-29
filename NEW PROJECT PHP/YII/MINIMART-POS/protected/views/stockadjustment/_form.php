<?php
/* @var $this StockadjustmentController */
/* @var $model Stockadjustment */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'stockadjustment-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'referenceno'); ?>
		<?php echo $form->textField($model,'referenceno',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'referenceno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dateofadjustment'); ?>
		<?php echo $form->textField($model,'dateofadjustment'); ?>
		<?php echo $form->error($model,'dateofadjustment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->textField($model,'stock'); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock_adjustment'); ?>
		<?php echo $form->textField($model,'stock_adjustment'); ?>
		<?php echo $form->error($model,'stock_adjustment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Remarks'); ?>
		<?php echo $form->textArea($model,'Remarks',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'Remarks'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
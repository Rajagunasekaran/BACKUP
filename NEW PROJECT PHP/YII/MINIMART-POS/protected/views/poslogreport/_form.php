<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'poslogreport-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barcode'); ?>
		<?php echo $form->textField($model,'barcode',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'barcode'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'previous_stock'); ?>
		<?php echo $form->textField($model,'previous_stock'); ?>
		<?php echo $form->error($model,'previous_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'current_stock'); ?>
		<?php echo $form->textField($model,'current_stock'); ?>
		<?php echo $form->error($model,'current_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sold_out'); ?>
		<?php echo $form->textField($model,'sold_out'); ?>
		<?php echo $form->error($model,'sold_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'today_purchase'); ?>
		<?php echo $form->textField($model,'today_purchase'); ?>
		<?php echo $form->error($model,'today_purchase'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'current_aval_stock'); ?>
		<?php echo $form->textField($model,'current_aval_stock'); ?>
		<?php echo $form->error($model,'current_aval_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'log_status'); ?>
		<?php echo $form->textField($model,'log_status'); ?>
		<?php echo $form->error($model,'log_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
		<?php echo $form->error($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
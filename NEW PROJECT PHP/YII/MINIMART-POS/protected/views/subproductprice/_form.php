<?php
/* @var $this SubproductpriceController */
/* @var $model Subproductprice */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'subproductprice-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'product_id'); ?>
		<?php echo $form->textField($model,'product_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'product_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>16,'maxlength'=>16)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sku'); ?>
		<?php echo $form->textField($model,'sku',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'sku'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'supplier_id'); ?>
		<?php echo $form->textField($model,'supplier_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'supplier_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_cp'); ?>
		<?php echo $form->textField($model,'unit_cp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'unit_cp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sptype'); ?>
		<?php echo $form->textField($model,'sptype'); ?>
		<?php echo $form->error($model,'sptype'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_sp_per'); ?>
		<?php echo $form->textField($model,'unit_sp_per',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'unit_sp_per'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_sp'); ?>
		<?php echo $form->textField($model,'unit_sp',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'unit_sp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stock'); ?>
		<?php echo $form->textField($model,'stock'); ?>
		<?php echo $form->error($model,'stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'stockvalue'); ?>
		<?php echo $form->textField($model,'stockvalue',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'stockvalue'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rol'); ?>
		<?php echo $form->textField($model,'rol'); ?>
		<?php echo $form->error($model,'rol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'moq'); ?>
		<?php echo $form->textField($model,'moq'); ?>
		<?php echo $form->error($model,'moq'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'dontsyncwithstock'); ?>
		<?php echo $form->textField($model,'dontsyncwithstock'); ?>
		<?php echo $form->error($model,'dontsyncwithstock'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tax'); ?>
		<?php echo $form->textField($model,'tax',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'tax'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'disc'); ?>
		<?php echo $form->textField($model,'disc',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'disc'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_at'); ?>
		<?php echo $form->textField($model,'created_at'); ?>
		<?php echo $form->error($model,'created_at'); ?>
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
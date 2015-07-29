<?php
/* @var $this PoslogreportController */
/* @var $model Poslogreport */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'sno'); ?>
		<?php echo $form->textField($model,'sno'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'barcode'); ?>
		<?php echo $form->textField($model,'barcode',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'previous_stock'); ?>
		<?php echo $form->textField($model,'previous_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'current_stock'); ?>
		<?php echo $form->textField($model,'current_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sold_out'); ?>
		<?php echo $form->textField($model,'sold_out'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'today_purchase'); ?>
		<?php echo $form->textField($model,'today_purchase'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'current_aval_stock'); ?>
		<?php echo $form->textField($model,'current_aval_stock'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log_status'); ?>
		<?php echo $form->textField($model,'log_status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'updated_at'); ?>
		<?php echo $form->textField($model,'updated_at'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
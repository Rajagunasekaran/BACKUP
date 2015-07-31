<?php
/* @var $this PoslogreportController */
/* @var $data Poslogreport */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sno')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sno), array('view', 'id'=>$data->sno)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('barcode')); ?>:</b>
	<?php echo CHtml::encode($data->barcode); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('previous_stock')); ?>:</b>
	<?php echo CHtml::encode($data->previous_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('current_stock')); ?>:</b>
	<?php echo CHtml::encode($data->current_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sold_out')); ?>:</b>
	<?php echo CHtml::encode($data->sold_out); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('today_purchase')); ?>:</b>
	<?php echo CHtml::encode($data->today_purchase); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('current_aval_stock')); ?>:</b>
	<?php echo CHtml::encode($data->current_aval_stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log_status')); ?>:</b>
	<?php echo CHtml::encode($data->log_status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>
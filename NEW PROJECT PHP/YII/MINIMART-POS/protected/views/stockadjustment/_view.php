<?php
/* @var $this StockadjustmentController */
/* @var $data Stockadjustment */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sno')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sno), array('view', 'id'=>$data->sno)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('referenceno')); ?>:</b>
	<?php echo CHtml::encode($data->referenceno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dateofadjustment')); ?>:</b>
	<?php echo CHtml::encode($data->dateofadjustment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo CHtml::encode($data->code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sku')); ?>:</b>
	<?php echo CHtml::encode($data->sku); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock')); ?>:</b>
	<?php echo CHtml::encode($data->stock); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('stock_adjustment')); ?>:</b>
	<?php echo CHtml::encode($data->stock_adjustment); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('Remarks')); ?>:</b>
	<?php echo CHtml::encode($data->Remarks); ?>
	<br />

	*/ ?>

</div>
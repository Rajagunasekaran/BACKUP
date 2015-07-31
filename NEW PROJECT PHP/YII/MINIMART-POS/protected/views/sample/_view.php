<?php
/* @var $this SampleController */
/* @var $data Sample */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('sno')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->sno), array('view', 'id'=>$data->sno)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />


</div>
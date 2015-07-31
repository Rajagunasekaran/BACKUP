<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('config_key')); ?>:</b>
	<?php echo CHtml::encode($data->config_key); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('config_val')); ?>:</b>
	<?php echo CHtml::encode($data->config_val); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
	<br />


</div>
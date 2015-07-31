<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('forwhat')); ?>:</b>
	<?php echo CHtml::encode($data->forwhat); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('foryear')); ?>:</b>
	<?php echo CHtml::encode($data->foryear); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('formonth')); ?>:</b>
	<?php echo CHtml::encode($data->formonth); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastid')); ?>:</b>
	<?php echo CHtml::encode($data->lastid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />


</div>
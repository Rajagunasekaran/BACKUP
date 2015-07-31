<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desc')); ?>:</b>
	<?php echo CHtml::encode($data->desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('login_id')); ?>:</b>
	<?php echo CHtml::encode($data->login_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('open_time')); ?>:</b>
	<?php echo CHtml::encode($data->open_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('close_time')); ?>:</b>
	<?php echo CHtml::encode($data->close_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('op_balance')); ?>:</b>
	<?php echo CHtml::encode($data->op_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cl_balance')); ?>:</b>
	<?php echo CHtml::encode($data->cl_balance); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('net_collection')); ?>:</b>
	<?php echo CHtml::encode($data->net_collection); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('isdefault')); ?>:</b>
	<?php echo CHtml::encode($data->isdefault); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>
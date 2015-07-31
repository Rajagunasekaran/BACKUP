<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ofwhich_id')); ?>:</b>
	<?php echo CHtml::encode($data->ofwhich_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status1dt')); ?>:</b>
	<?php echo CHtml::encode($data->status1dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status2dt')); ?>:</b>
	<?php echo CHtml::encode($data->status2dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status3dt')); ?>:</b>
	<?php echo CHtml::encode($data->status3dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status4dt')); ?>:</b>
	<?php echo CHtml::encode($data->status4dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status5dt')); ?>:</b>
	<?php echo CHtml::encode($data->status5dt); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('status6dt')); ?>:</b>
	<?php echo CHtml::encode($data->status6dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status7dt')); ?>:</b>
	<?php echo CHtml::encode($data->status7dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status8dt')); ?>:</b>
	<?php echo CHtml::encode($data->status8dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status9dt')); ?>:</b>
	<?php echo CHtml::encode($data->status9dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status10dt')); ?>:</b>
	<?php echo CHtml::encode($data->status10dt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>
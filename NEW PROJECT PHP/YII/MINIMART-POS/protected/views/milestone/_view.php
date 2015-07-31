<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('person_id')); ?>:</b>
	<?php echo CHtml::encode($data->person_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('details')); ?>:</b>
	<?php echo CHtml::encode($data->details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_at')); ?>:</b>
	<?php echo CHtml::encode($data->start_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_at')); ?>:</b>
	<?php echo CHtml::encode($data->end_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('alertbefore')); ?>:</b>
	<?php echo CHtml::encode($data->alertbefore); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed')); ?>:</b>
	<?php echo CHtml::encode($data->completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed_at')); ?>:</b>
	<?php echo CHtml::encode($data->completed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed_remarks')); ?>:</b>
	<?php echo CHtml::encode($data->completed_remarks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailids')); ?>:</b>
	<?php echo CHtml::encode($data->mailids); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mailcount')); ?>:</b>
	<?php echo CHtml::encode($data->mailcount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastmailsent_at')); ?>:</b>
	<?php echo CHtml::encode($data->lastmailsent_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('started_at')); ?>:</b>
	<?php echo CHtml::encode($data->started_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('closed_at')); ?>:</b>
	<?php echo CHtml::encode($data->closed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>
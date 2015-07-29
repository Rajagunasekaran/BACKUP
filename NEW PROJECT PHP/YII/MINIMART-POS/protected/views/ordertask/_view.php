<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_type')); ?>:</b>
	<?php echo CHtml::encode($data->order_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('task_id')); ?>:</b>
	<?php echo CHtml::encode($data->task_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('details')); ?>:</b>
	<?php echo CHtml::encode($data->details); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_at')); ?>:</b>
	<?php echo CHtml::encode($data->start_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_at')); ?>:</b>
	<?php echo CHtml::encode($data->end_at); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('started_at')); ?>:</b>
	<?php echo CHtml::encode($data->started_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('closed_at')); ?>:</b>
	<?php echo CHtml::encode($data->closed_at); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invstatus')); ?>:</b>
	<?php echo CHtml::encode($data->invstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cost')); ?>:</b>
	<?php echo CHtml::encode($data->cost); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('amount')); ?>:</b>
	<?php echo CHtml::encode($data->amount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxper')); ?>:</b>
	<?php echo CHtml::encode($data->taxper); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tax')); ?>:</b>
	<?php echo CHtml::encode($data->tax); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('alertbefore')); ?>:</b>
	<?php echo CHtml::encode($data->alertbefore); ?>
	<br />

	*/ ?>

</div>
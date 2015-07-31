<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qoi_id')); ?>:</b>
	<?php echo CHtml::encode($data->qoi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quote_qoi_id')); ?>:</b>
	<?php echo CHtml::encode($data->quote_qoi_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_qoi_id')); ?>:</b>
	<?php echo CHtml::encode($data->order_qoi_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('desc')); ?>:</b>
	<?php echo CHtml::encode($data->desc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo1')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo2')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo3')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo3); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo4')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('addnlinfo5')); ?>:</b>
	<?php echo CHtml::encode($data->addnlinfo5); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_at')); ?>:</b>
	<?php echo CHtml::encode($data->start_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_at')); ?>:</b>
	<?php echo CHtml::encode($data->end_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('budget')); ?>:</b>
	<?php echo CHtml::encode($data->budget); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('discper')); ?>:</b>
	<?php echo CHtml::encode($data->discper); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('disc')); ?>:</b>
	<?php echo CHtml::encode($data->disc); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tasks')); ?>:</b>
	<?php echo CHtml::encode($data->tasks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('completed')); ?>:</b>
	<?php echo CHtml::encode($data->completed); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('invstatus')); ?>:</b>
	<?php echo CHtml::encode($data->invstatus); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('paid')); ?>:</b>
	<?php echo CHtml::encode($data->paid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('qutcnvrtdate')); ?>:</b>
	<?php echo CHtml::encode($data->qutcnvrtdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordcnvrtdate')); ?>:</b>
	<?php echo CHtml::encode($data->ordcnvrtdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('started_at')); ?>:</b>
	<?php echo CHtml::encode($data->started_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('closed_at')); ?>:</b>
	<?php echo CHtml::encode($data->closed_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('delivered')); ?>:</b>
	<?php echo CHtml::encode($data->delivered); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordername')); ?>:</b>
	<?php echo CHtml::encode($data->enableordername); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordrprd')); ?>:</b>
	<?php echo CHtml::encode($data->enableordrprd); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordrtasks')); ?>:</b>
	<?php echo CHtml::encode($data->enableordrtasks); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordrtaskpeople')); ?>:</b>
	<?php echo CHtml::encode($data->enableordrtaskpeople); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordrpayments')); ?>:</b>
	<?php echo CHtml::encode($data->enableordrpayments); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enableordermilestones')); ?>:</b>
	<?php echo CHtml::encode($data->enableordermilestones); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordercostamountfrom')); ?>:</b>
	<?php echo CHtml::encode($data->ordercostamountfrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ordertaskcostamountfrom')); ?>:</b>
	<?php echo CHtml::encode($data->ordertaskcostamountfrom); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('enablediscount')); ?>:</b>
	<?php echo CHtml::encode($data->enablediscount); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('orderdiscfor')); ?>:</b>
	<?php echo CHtml::encode($data->orderdiscfor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updated_at')); ?>:</b>
	<?php echo CHtml::encode($data->updated_at); ?>
	<br />

	*/ ?>

</div>
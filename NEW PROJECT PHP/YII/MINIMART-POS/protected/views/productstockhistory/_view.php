<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('productprice_id')); ?>:</b>
	<?php echo CHtml::encode($data->productprice_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updationdate')); ?>:</b>
	<?php echo CHtml::encode($data->updationdate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('beforeupdation')); ?>:</b>
	<?php echo CHtml::encode($data->beforeupdation); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('updatedqnty')); ?>:</b>
	<?php echo CHtml::encode($data->updatedqnty); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('afterupdation')); ?>:</b>
	<?php echo CHtml::encode($data->afterupdation); ?>
	<br />


</div>
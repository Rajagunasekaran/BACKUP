<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxname')); ?>:</b>
	<?php echo CHtml::encode($data->taxname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxrate')); ?>:</b>
	<?php echo CHtml::encode($data->taxrate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('taxtype')); ?>:</b>
	<?php echo CHtml::encode($data->taxtype); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('remarks')); ?>:</b>
	<?php echo CHtml::encode($data->remarks); ?>
	<br />


</div>
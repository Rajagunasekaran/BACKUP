<?php
$this->breadcrumbs=array(
	'Payments'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Payment','url'=>array('index')),
array('label'=>'Create Payment','url'=>array('create')),
array('label'=>'Update Payment','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Payment','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Payment','url'=>array('admin')),
);
?>

<h1>View Payment #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'person_id',
		'account_id',
		'party_id',
		'ordertask_id',
		'order_id',
		'type',
		'amount',
		'status',
		'details',
		'payment_at',
		'collected_at',
		'direction',
		'created_at',
		'updated_at',
),
)); ?>

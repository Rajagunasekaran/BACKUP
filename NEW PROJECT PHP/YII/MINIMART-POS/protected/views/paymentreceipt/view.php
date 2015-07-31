<?php
$this->breadcrumbs=array(
	'Paymentreceipts'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Paymentreceipt','url'=>array('index')),
array('label'=>'Create Paymentreceipt','url'=>array('create')),
array('label'=>'Update Paymentreceipt','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Paymentreceipt','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Paymentreceipt','url'=>array('admin')),
);
?>

<h1>View Paymentreceipt #<?php echo $model->id; ?></h1>

<?php $this->widget('booster.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'customer_id',
		'amount',
		'details',
		'paid_date',
		'created_at',
		'updated_at',
),
)); ?>
